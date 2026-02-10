@extends('layout.app')

@section('title', $album->title)

@section('styles')
<style>
    .album-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin: 2rem 0;
    }
    
    .album-image {
        width: 100%;
        aspect-ratio: 1;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
    }
    
    .album-content h1 {
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .album-artist {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 1rem;
    }
    
    .album-description {
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .album-price {
        font-size: 2rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 2rem;
    }
    
    .btn-acheter {
        width: 100%;
        padding: 1rem;
        background-color: #27ae60;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .btn-acheter:hover {
        background-color: #229954;
    }
    
    .tracks-section {
        margin-top: 3rem;
    }
    
    .track-list {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .track-item {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .track-item:last-child {
        border-bottom: none;
    }
    
    .track-number {
        font-weight: bold;
        margin-right: 1rem;
        width: 30px;
    }
    
    .track-name {
        flex: 1;
    }
    
    .track-duration {
        color: #999;
        min-width: 60px;
    }
    
    @media (max-width: 768px) {
        .album-detail {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="album-detail">
    <div class="album-image">
        @if($album->cover_image)
            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
        @else
            🎵
        @endif
    </div>
    <div class="album-content">
        <h1>{{ $album->title }}</h1>
        <div class="album-artist">par {{ $album->artist_name }}</div>
        
        @if($album->description)
            <div class="album-description">{{ $album->description }}</div>
        @endif
        
        <div class="album-price">{{ number_format($album->price, 0) }} Ar</div>
        
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <input type="hidden" name="album_id" value="{{ $album->id }}">
            <button type="submit" class="btn-acheter">Acheter</button>
        </form>
    </div>
</div>

<div class="tracks-section">
    <h2>Morceaux ({{ $album->tracks->count() }}):</h2>
    <div class="track-list">
        @foreach($album->tracks as $track)
            <div class="track-item">
                <div class="track-number">{{ $loop->iteration }}</div>
                <div class="track-name">{{ $track->title }}</div>
                <div class="track-duration">
                    {{ intval($track->duration / 60) }}:{{ str_pad($track->duration % 60, 2, '0', STR_PAD_LEFT) }}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
