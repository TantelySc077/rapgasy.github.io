@extends('layout.app')

@section('title', 'Test Création Album')

@section('content')
<div style="max-width: 600px; margin: 2rem auto; padding: 2rem; background: white; border-radius: 10px;">
    <h1>Test Formulaire Simple</h1>
    
    @if($errors->any())
        <div style="background: #f8d7da; padding: 1rem; margin-bottom: 1rem; border-radius: 5px;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li style="color: #721c24;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.albums.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1rem;">
            <label>Titre de l'album *</label>
            <input type="text" name="title" value="{{ old('title') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label>Nom de l'artiste *</label>
            <input type="text" name="artist_name" value="{{ old('artist_name') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label>Prix (Ar) *</label>
            <input type="number" name="price" value="{{ old('price', 1000) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <button type="submit" style="background: #3498db; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
            Créer l'album TEST
        </button>
    </form>
</div>
@endsection
