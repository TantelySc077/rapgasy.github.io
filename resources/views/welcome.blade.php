@extends('layout.app')

@section('title', 'Musique Store - Accueil')

@section('styles')
<style>
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
    }
    
    .btn-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
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
    }
    
    .btn-primary {
        background-color: white;
        color: #667eea;
        font-weight: bold;
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
    }
    
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    
    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
    }
    
    .feature-card h3 {
        color: #667eea;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="hero">
    <h1>Bienvenue sur notre <br> Plateforme de vente d'Album</h1>
    <p>ALBUM RAP GASY</p>
    <div class="btn-group">
        @auth
            <a href="{{ route('albums.index') }}" class="btn btn-primary">Voir les Albums</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
            <a href="{{ route('login') }}" class="btn btn-secondary">Se connecter</a>
        @endauth
    </div>
</div>

<div class="features">
    <div class="feature-card">
        <h3>🎵 Albums Variés</h3>
        <p>Accédez à une large collection d'albums de différents genres musicaux</p>
    </div>
    <div class="feature-card">
        <h3>💳 Paiement Sécurisé</h3>
        <p>Paiement via MVola, Orange Money et Airtel Money</p>
    </div>
    <div class="feature-card">
        <h3>⬇️ Téléchargement Facile</h3>
        <p>Une fois validées, téléchargez vos albums en un clic</p>
    </div>
</div>
@endsection
