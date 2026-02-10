@extends('layout.app')

@section('title', 'Détails de l\'album')

@section('styles')
<style>
    .details-container {
        max-width: 800px;
        margin: 2rem auto;
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .album-header {
        display: flex;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .album-cover {
        width: 250px;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .album-info {
        flex: 1;
    }

    .album-title {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .album-artist {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .album-meta {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0.5rem 1rem;
        margin-bottom: 1.5rem;
    }

    .meta-label {
        font-weight: bold;
        color: #555;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.9rem;
        font-weight: bold;
        color: white;
    }

    .status-published {
        background-color: #2ecc71;
    }

    .status-draft {
        background-color: #95a5a6;
    }

    .tracks-list {
        margin-top: 2rem;
    }

    .track-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem;
        border-bottom: 1px solid #eee;
    }
    
    .track-item:last-child {
        border-bottom: none;
    }

    .btn-edit {
        background-color: #3498db;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-back {
        color: #666;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .file-info {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 5px;
        border: 1px solid #e9ecef;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #27ae60;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="details-container">
    <div class="header-actions">
        <a href="{{ route('admin.albums.index') }}" class="btn-back">
            ← Retour à la liste
        </a>
        <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn-edit">
            Modifier l'album
        </a>
    </div>

    <div class="album-header">
        <div>
            @if($album->cover_image)
                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="album-cover">
            @else
                <div class="album-cover" style="background: #eee; display: flex; align-items: center; justify-content: center; color: #999;">
                    Pas d'image
                </div>
            @endif
        </div>
        
        <div class="album-info">
            <h1 class="album-title">{{ $album->title }}</h1>
            <p class="album-artist">Par {{ $album->artist_name }}</p>

            <div class="album-meta">
                <span class="meta-label">Prix : </span>
                <span>{{ number_format($album->price, 0) }} Ar</span>

                <span class="meta-label">Statut : </span>
                <span>
                    @if($album->is_published)
                        <span class="status-badge status-published">Publié</span>
                    @else
                        <span class="status-badge status-draft">Brouillon</span>
                    @endif
                </span>

                <span class="meta-label">Créé le:</span>
                <span>{{ $album->created_at->format('d/m/Y') }}</span>
            </div>

            @if($album->description)
                <div style="margin-bottom: 1.5rem; color: #666; line-height: 1.6;">
                    {{ $album->description }}
                </div>
            @endif

            @if($album->file_path)
                <div class="file-info">
                    <span>📦 Fichier de l'album :</span>
                    <span>{{ basename($album->file_path) }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="tracks-list">
        <h3 style="border-bottom: 2px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem;">
            Pistes ({{ $album->tracks->count() }})
        </h3>
        
        @if($album->tracks->count() > 0)
            @foreach($album->tracks as $index => $track)
                <div class="track-item">
                    <span><strong>{{ $index + 1 }}.</strong> {{ $track->title }}</span>
                    <span style="color: #666;">
                        {{ gmdate("i:s", $track->duration) }}
                    </span>
                </div>
            @endforeach
        @else
            <p style="color: #999; font-style: italic;">Aucune piste ajoutée.</p>
        @endif
    </div>
</div>
@endsection
