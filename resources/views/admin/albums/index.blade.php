@extends('layout.app')

@section('title', 'Gérer les albums')

@section('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .btn-create {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
    }
    
    .albums-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .albums-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .albums-table th {
        padding: 1rem;
        text-align: left;
        font-weight: bold;
    }
    
    .albums-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .albums-table tbody tr:hover {
        background-color: #f5f5f5;
    }
    
    .btn-action {
        padding: 0.4rem 0.8rem;
        margin-right: 0.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 0.9rem;
    }
    
    .btn-edit {
        background-color: #3498db;
        color: white;
    }
    
    .btn-edit:hover {
        background-color: #2980b9;
    }
    
    .btn-delete {
        background-color: #e74c3c;
        color: white;
    }
    
    .btn-delete:hover {
        background-color: #c0392b;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin: 2rem 0;
    }
    
    .empty-message {
        text-align: center;
        padding: 2rem;
        color: #666;
    }
</style>
@endsection

@section('content')
<div class="admin-header">
    <h1>Mes Albums</h1>
    <a href="{{ route('admin.albums.create') }}" class="btn-create">➕ Ajouter un album</a>
</div>

@if($albums->count() > 0)
    <table class="albums-table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Artiste</th>
                <th>Morceaux</th>
                <th>Statut</th>
                <th>Prix</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>{{ $album->title }}</td>
                    <td>{{ $album->artist_name }}</td>
                    <td>{{ $album->tracks->count() }}</td>
                    <td>
                        @if($album->is_published)
                            <span style="background-color: #2ecc71; color: white; padding: 0.25rem 0.5rem; border-radius: 5px; font-size: 0.8rem;">Publié</span>
                        @else
                            <span style="background-color: #95a5a6; color: white; padding: 0.25rem 0.5rem; border-radius: 5px; font-size: 0.8rem;">Brouillon</span>
                        @endif
                    </td>
                    <td>{{ number_format($album->price, 0) }} Ar</td>
                    <td>{{ $album->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn-action btn-edit">Modifier</a>
                        <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination">
        {{ $albums->links() }}
    </div>
@else
    <div class="empty-message">
        <p>Vous n'avez pas encore d'album.</p>
        <a href="{{ route('admin.albums.create') }}" class="btn-create" style="margin-top: 1rem;">Créer le premier album</a>
    </div>
@endif
@endsection
