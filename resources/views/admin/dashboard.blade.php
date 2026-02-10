@extends('layout.app')

@section('title', 'Dashboard Admin')

@section('styles')
<style>
    .admin-container {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
    }

    .sidebar {
        width: 250px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 0;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .sidebar-item {
        display: block;
        padding: 1rem 1.5rem;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #eee;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .sidebar-item:last-child {
        border-bottom: none;
    }

    .sidebar-item:hover {
        background-color: #f5f5f5;
        padding-left: 2rem;
    }

    .sidebar-item-icon {
        font-size: 1.2rem;
    }

    .sidebar-item-label {
        flex: 1;
    }

    .sidebar-item.btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        margin: 1rem;
        border-radius: 5px;
        border-bottom: none;
    }

    .sidebar-item.btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        padding-left: 1.5rem;
    }

    .main-content {
        flex: 1;
    }

    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4rem 1rem;
        text-align: center;
        border-radius: 10px;
        margin-bottom: 3rem;
    }

    .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .btn-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
    }

    .btn-primary {
        background-color: white;
        color: #667eea;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-secondary {
        background-color: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid white;
    }

    .btn-secondary:hover {
        background-color: rgba(255,255,255,0.3);
        transform: translateY(-2px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .stat-card .btn {
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
    }

    .stat-card .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .action-section {
        margin-top: 3rem;
    }

    .action-section h2 {
        color: #333;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .admin-container {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            display: flex;
            max-width: none;
            position: static;
        }

        .sidebar-item {
            flex: 1;
            border-right: 1px solid #eee;
            border-bottom: none;
        }

        .sidebar-item:last-child {
            border-right: none;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <a href="{{ route('admin.albums.create') }}" class="sidebar-item btn-add">
            <span class="sidebar-item-icon">➕</span>
            <span class="sidebar-item-label">Ajouter Album</span>
        </a>
        <a href="{{ route('admin.albums.index') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📀</span>
            <span class="sidebar-item-label">Mes Albums</span>
        </a>
        <a href="{{ route('admin.pending-orders') }}" class="sidebar-item">
            <span class="sidebar-item-icon">⏳</span>
            <span class="sidebar-item-label">Paiements en attente</span>
        </a>
        <a href="{{ route('admin.payments.history') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📊</span>
            <span class="sidebar-item-label">Historique paiements</span>
        </a>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="hero">
            <h1>Bienvenue Administrateur</h1>
            <p>Gérez vos albums et validez les paiements de vos clients</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📀</div>
                <div class="stat-value">{{ $totalAlbums }}</div>
                <div class="stat-label">Albums disponibles</div>
                <a href="{{ route('admin.albums.index') }}" class="btn" style="background-color: #667eea; color: white; margin-top: 1rem;">Voir mes albums</a>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-value">{{ $pendingPayments }}</div>
                <div class="stat-label">Paiements en attente</div>
                <a href="{{ route('admin.pending-orders') }}" class="btn" style="background-color: #f39c12; color: white; margin-top: 1rem;">Valider</a>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value">{{ number_format($totalPayments, 0) }} Ar</div>
                <div class="stat-label">Total approuvé</div>
                <a href="{{ route('admin.payments.history') }}" class="btn" style="background-color: #27ae60; color: white; margin-top: 1rem;">Historique</a>
            </div>
        </div>

        <div class="action-section">
            <h2>Actions rapides</h2>
            <div class="stats-grid">
                <a href="{{ route('admin.albums.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="stat-card">
                        <div class="stat-icon">➕</div>
                        <div class="stat-label" style="font-size: 1rem; font-weight: 500;">Créer un nouvel album</div>
                        <p style="color: #999; font-size: 0.9rem;">Ajouter un album, des morceaux et une image de couverture</p>
                    </div>
                </a>
                <a href="{{ route('admin.pending-orders') }}" style="text-decoration: none; color: inherit;">
                    <div class="stat-card">
                        <div class="stat-icon">🔍</div>
                        <div class="stat-label" style="font-size: 1rem; font-weight: 500;">Valider les paiements</div>
                        <p style="color: #999; font-size: 0.9rem;">Approuver ou rejeter les paiements en attente</p>
                    </div>
                </a>
                <a href="{{ route('admin.payments.history') }}" style="text-decoration: none; color: inherit;">
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-label" style="font-size: 1rem; font-weight: 500;">Voir l'historique</div>
                        <p style="color: #999; font-size: 0.9rem;">Consulter tous les paiements et leurs statuts</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
