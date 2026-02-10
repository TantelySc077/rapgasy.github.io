<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Dashboard de l'administrateur
    public function dashboard()
    {
        $totalPayments = Payment::where('status', 'approved')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalAlbums = Album::count();
        
        return view('admin.dashboard', compact('totalPayments', 'pendingPayments', 'totalAlbums'));
    }

    // Afficher la liste des albums de l'administrateur
    public function index()
    {
        $albums = Album::latest()->paginate(10);
        return view('admin.albums.index', compact('albums'));
    }

    // Formulaire de création d'album
    public function create()
    {
        return view('admin.albums.create');
    }

    // Créer un nouvel album
    public function store(Request $request)
    {
        $validated = $request->validate([
            'artist_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'album_file' => 'nullable|file|mimes:zip,rar,7z|max:204800',
            'tracks' => 'nullable|array',
            'tracks.*.title' => 'required_with:tracks|string|max:255',
            'tracks.*.duration' => 'required_with:tracks|numeric|min:1',
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'numeric' => 'Le champ :attribute doit être un nombre.',
            'min' => 'Le champ :attribute doit être au moins :min.',
            'max' => 'Le champ :attribute ne doit pas dépasser :max.',
            'image' => 'Le fichier doit être une image.',
            'mimes' => 'Le fichier doit être de type :values.',
            'file' => 'Le champ doit être un fichier valide.',
            'required_with' => 'Le champ :attribute est requis.',
        ], [
            'artist_name' => 'Nom de l\'artiste',
            'title' => 'Titre',
            'price' => 'Prix',
            'description' => 'Description',
            'cover_image' => 'Image de couverture',
            'album_file' => 'Fichier de l\'album',
            'tracks.*.title' => 'Titre du morceau',
            'tracks.*.duration' => 'Durée du morceau',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('albums', 'public');
            $validated['cover_image'] = $imagePath;
        }

        // Gérer l'upload du fichier album
        $albumFilePath = null;
        if ($request->hasFile('album_file')) {
            $albumFilePath = $request->file('album_file')->store('album_files', 'public');
        }

        $album = Album::create([
            'user_id' => Auth::id(),
            'artist_name' => $validated['artist_name'],
            'title' => $validated['title'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'cover_image' => $validated['cover_image'] ?? null,
            'file_path' => $albumFilePath,
            'is_published' => $request->has('is_published'),
        ]);

        // Créer les morceaux (saisie manuelle uniquement)
        if (!empty($validated['tracks'])) {
            foreach ($validated['tracks'] as $trackData) {
                \App\Models\Track::create([
                    'album_id' => $album->id,
                    'title' => $trackData['title'],
                    'duration' => (int)$trackData['duration'],
                    'file_path' => 'audio/dummy.mp3',
                ]);
            }
        }

        return redirect()->route('admin.albums.show', $album->id)
                        ->with('success', 'Album créé avec succès avec ' . count($validated['tracks'] ?? []) . ' morceau(x).');
    }

    // Afficher les détails d'un album pour l'admin
    public function show(string $id)
    {
        $album = Album::findOrFail($id);
        
        // Vérifier que l'album appartient à l'utilisateur connecté
        if ($album->user_id !== Auth::id()) {
            abort(403);
        }

        return view('admin.albums.show', compact('album'));
    }

    // Formulaire d'édition d'album
    public function edit(string $id)
    {
        $album = Album::findOrFail($id);
        return view('admin.albums.edit', compact('album'));
    }

    // Mettre à jour un album
    public function update(Request $request, string $id)
    {
        $album = Album::findOrFail($id);

        $validated = $request->validate([
            'artist_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'numeric' => 'Le champ :attribute doit être un nombre.',
            'min' => 'Le champ :attribute doit être au moins :min.',
            'max' => 'Le champ :attribute ne doit pas dépasser :max.',
            'image' => 'Le fichier doit être une image.',
            'mimes' => 'Le fichier doit être de type :values.',
        ], [
            'artist_name' => 'Nom de l\'artiste',
            'title' => 'Titre',
            'price' => 'Prix',
            'description' => 'Description',
            'cover_image' => 'Image de couverture',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image
            if ($album->cover_image && \Storage::disk('public')->exists($album->cover_image)) {
                \Storage::disk('public')->delete($album->cover_image);
            }
            // Uploader la nouvelle image
            $imagePath = $request->file('cover_image')->store('albums', 'public');
            $validated['cover_image'] = $imagePath;
            $validated['cover_image'] = $imagePath;
        }

        // Gérer l'upload du fichier album
        $updateData = $validated;
        if ($request->hasFile('album_file')) {
            // Supprimer l'ancien fichier
            if ($album->file_path && \Storage::disk('public')->exists($album->file_path)) {
                \Storage::disk('public')->delete($album->file_path);
            }
            $albumFilePath = $request->file('album_file')->store('album_files', 'public');
            $updateData['file_path'] = $albumFilePath;
        }

        $album->update(array_merge($updateData, [
            'is_published' => $request->has('is_published'),
        ]));

        // Handle new tracks (metadata only)
        if ($request->has('new_tracks')) {
            $request->validate([
                'new_tracks' => 'array',
                'new_tracks.*.title' => 'required|string|max:255',
                'new_tracks.*.duration' => 'required|numeric|min:1',
            ], [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'numeric' => 'Le champ :attribute doit être un nombre.',
                'min' => 'Le champ :attribute doit être au moins :min.',
            ], [
                'new_tracks.*.title' => 'Titre du morceau',
                'new_tracks.*.duration' => 'Durée du morceau',
            ]);

            foreach ($request->new_tracks as $trackData) {
                \App\Models\Track::create([
                    'album_id' => $album->id,
                    'title' => $trackData['title'],
                    'duration' => (int)$trackData['duration'],
                    'file_path' => 'audio/dummy.mp3',
                ]);
            }
        }

        return redirect()->route('admin.albums.edit', $album->id)
                        ->with('success', 'Album mis à jour avec succès.');
    }

    // Supprimer un morceau
    public function destroyTrack(string $id)
    {
        $track = \App\Models\Track::findOrFail($id);

        // Delete file
        if ($track->file_path && \Storage::disk('public')->exists($track->file_path)) {
            \Storage::disk('public')->delete($track->file_path);
        }

        $track->delete();

        return back()->with('success', 'Morceau supprimé.');
    }

    // Supprimer un album
    public function destroy(string $id)
    {
        $album = Album::findOrFail($id);

        // Supprimer l'image
        if ($album->cover_image && \Storage::disk('public')->exists($album->cover_image)) {
            \Storage::disk('public')->delete($album->cover_image);
        }

        // Supprimer le fichier album
        if ($album->file_path && \Storage::disk('public')->exists($album->file_path)) {
            \Storage::disk('public')->delete($album->file_path);
        }

        $album->delete();

        return redirect()->route('admin.albums.index')
                        ->with('success', 'Album supprimé avec succès.');
    }

    // Afficher la liste des paiements en attente
    public function paymentHistory()
    {
        $payments = Payment::with('order.user', 'order.album')->paginate(10);
        return view('admin.payments.history', compact('payments'));
    }

    // Afficher les commandes en attente de validation
    public function pendingOrders()
    {
        $pendingPayments = Payment::where('status', 'pending')
            ->with('order.user', 'order.album')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.pending-orders', compact('pendingPayments'));
    }

    // Approuver un paiement
    public function approvePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'approved']);
        
        // Mettre à jour le statut de la commande
        $payment->order->update(['status' => 'completed']);

        return back()->with('success', 'Paiement approuvé. Le client peut maintenant télécharger l\'album.');
    }

    // Rejeter un paiement
    public function rejectPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'rejected']);
        
        // Mettre à jour le statut de la commande
        $payment->order->update(['status' => 'cancelled']);

        return back()->with('success', 'Paiement rejeté.');
    }

    /**
     * Extraire automatiquement les morceaux depuis un fichier ZIP
     */
    private function extractTracksFromZip(Album $album, string $zipPath)
    {
        $fullPath = Storage::disk('public')->path($zipPath);
        
        if (!file_exists($fullPath)) {
            return;
        }

        $zip = new \ZipArchive();
        if ($zip->open($fullPath) !== true) {
            return;
        }

        $audioExtensions = ['mp3', 'wav', 'ogg', 'flac', 'm4a'];
        $getID3 = new \getID3();
        $tempDir = storage_path('app/temp_extract');
        
        // Créer le dossier temporaire
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $fileInfo = pathinfo($filename);
            
            // Vérifier si c'est un fichier audio
            if (isset($fileInfo['extension']) && in_array(strtolower($fileInfo['extension']), $audioExtensions)) {
                // Extraire temporairement pour lire les métadonnées
                $tempFile = $tempDir . '/' . basename($filename);
                copy("zip://" . $fullPath . "#" . $filename, $tempFile);
                
                // Lire les métadonnées avec getID3
                $fileAnalysis = $getID3->analyze($tempFile);
                
                $title = $fileInfo['filename']; // Par défaut, nom du fichier
                $duration = 0;
                
                // Essayer de récupérer le titre et la durée
                if (isset($fileAnalysis['tags']['id3v2']['title'][0])) {
                    $title = $fileAnalysis['tags']['id3v2']['title'][0];
                } elseif (isset($fileAnalysis['tags']['id3v1']['title'][0])) {
                    $title = $fileAnalysis['tags']['id3v1']['title'][0];
                }
                
                if (isset($fileAnalysis['playtime_seconds'])) {
                    $duration = (int)$fileAnalysis['playtime_seconds'];
                }
                
                // Créer le track
                Track::create([
                    'album_id' => $album->id,
                    'title' => $title,
                    'duration' => $duration > 0 ? $duration : 180, // 3 min par défaut si non détecté
                    'file_path' => 'audio/dummy.mp3',
                ]);
                
                // Nettoyer le fichier temporaire
                unlink($tempFile);
            }
        }
        
        $zip->close();
        
        // Nettoyer le dossier temporaire
        if (file_exists($tempDir)) {
            rmdir($tempDir);
        }
    }
}
