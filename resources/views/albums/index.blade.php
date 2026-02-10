@extends('layout.app')

@section('title', 'Albums')

@section('styles')
<style>
    .albums-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }
    
    .album-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    
    .album-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .album-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        overflow: hidden;
    }
    
    .album-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        width: 100% !important;
        height: 100% !important;
    }
    
    .album-info {
        padding: 1.5rem;
    }
    
    .album-artist {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
    
    .album-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .album-tracks {
        font-size: 0.9rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .album-price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 1rem;
    }
    
    .btn {
        width: 100%;
        padding: 0.75rem;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.2s;
        text-decoration: none;
        text-align: center;
        display: block;
    }
    
    .btn:hover {
        background-color: #c0392b;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin: 2rem 0;
    }
</style>
@endsection

@section('content')
<h1>Albums Disponibles</h1>

<div class="albums-grid">
    @foreach($albums as $album)
        <div class="album-card">
            <div class="album-image">
                @if($album->cover_image)
                    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    🎵
                @endif
            </div>
            <div class="album-info">
                <div class="album-artist">{{ $album->artist_name }}</div>
                <div class="album-title">{{ $album->title }}</div>
                <div class="album-tracks">{{ $album->tracks->count() }} morceaux</div>
                <div class="album-price">{{ number_format($album->price, 0) }} Ar</div>
                <a href="{{ route('albums.show', $album->id) }}" class="btn">Ajouter au panier</a>
            </div>
        </div>
    @endforeach
</div>

<div class="pagination">
    {{ $albums->links() }}
</div>
@endsection
