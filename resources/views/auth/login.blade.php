@extends('layout.app')

@section('title', 'Connexion')

@section('styles')
<style>
    .auth-container {
        max-width: 400px;
        margin: 3rem auto;
    }
    
    .auth-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .auth-card h2 {
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #333;
    }
    
    input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }
    
    input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
    }
    
    .btn-submit {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
    }
    
    .auth-link {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .auth-link a {
        color: #667eea;
        text-decoration: none;
    }
    
    .auth-link a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Connexion</h2>
        
        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
        
        <div class="auth-link">
            Pas encore de compte? <a href="{{ route('register') }}">S'inscrire</a>
        </div>
    </div>
</div>
@endsection
