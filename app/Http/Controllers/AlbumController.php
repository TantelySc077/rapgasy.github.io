<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    // Afficher tous les albums disponibles
    public function index()
    {
        $albums = Album::with('tracks')->paginate(12);
        return view('albums.index', compact('albums'));
    }

    // Afficher les détails d'un album
    public function show($id)
    {
        $album = Album::with('tracks')->findOrFail($id);
        return view('albums.show', compact('album'));
    }

    // Ces méthodes seront utilisées par l'admin
    public function create()
    {
        return view('admin.albums.create');
    }

    public function store(Request $request)
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
