<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PaymentController extends Controller
{
    // Afficher la page de création de paiement
    public function create($orderId)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        $paymentMethods = ['MVola', 'Orange Money', 'Airtel Money'];
        return view('payments.create', compact('order', 'paymentMethods'));
    }

    // Afficher les détails du paiement
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        // Vérifier que le paiement appartient à l'utilisateur connecté
        if ($payment->order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('payments.show', compact('payment'));
    }

    // Stocker un nouveau paiement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'method' => 'required|in:MVola,Orange Money,Airtel Money',
            'reference' => 'required|string|unique:payments',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($validated['order_id']);

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'method' => $validated['method'],
            'reference' => $validated['reference'],
            'status' => 'pending',
        ]);

        return redirect()->route('payments.show', $payment->id)
                        ->with('success', 'Paiement en attente de validation de l\'administrateur.');
    }

    public function index()
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    // Permettre au client de télécharger l'album si le paiement est approuvé
    public function download($id)
    {
        $payment = Payment::with('order.album.tracks')->findOrFail($id);

        // Vérifier que le paiement appartient à l'utilisateur connecté
        if ($payment->order->user_id !== Auth::id()) {
            abort(403);
        }


        if ($payment->status !== 'approved') {
            return redirect()->back()->with('error', 'Le paiement n\'a pas encore été approuvé.');
        }

        // Vérifier que l'album est publié
        if (!$payment->order->album->is_published) {
            return redirect()->back()->with('error', 'Cet album n\'est pas encore disponible au téléchargement.');
        }

        if (!$payment->order->album->file_path || !Storage::disk('public')->exists($payment->order->album->file_path)) {
            return redirect()->back()->with('error', 'Le fichier de l\'album n\'est pas disponible.');
        }

        $filePath = Storage::disk('public')->path($payment->order->album->file_path);
        $fileName = \Str::slug($payment->order->album->title) . '.zip';

        return response()->download($filePath, $fileName);
    }
}
