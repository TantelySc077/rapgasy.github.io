<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;

class OrderController extends Controller
{
    // Afficher la liste des commandesde l'utilisateur
    public function index()
    {
        $orders = Auth::user()->orders()->with('album')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Afficher les détails d'une commande
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // Créer une nouvelle commande (ajouter au panier)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
        ]);

        $album = Album::findOrFail($validated['album_id']);

        $order = Order::create([
            'user_id' => Auth::id(),
            'album_id' => $album->id,
            'total_price' => $album->price,
            'status' => 'pending',
        ]);

        return redirect()->route('payments.create', $order->id)
                        ->with('success', 'Album ajouté au panier. Procédez au paiement.');
    }

    public function create()
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
}
