@extends('layout.app')

@section('title', 'Détails de la commande')

@section('styles')
<style>
    .order-detail {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 2rem auto;
    }
    
    .order-header {
        border-bottom: 2px solid #667eea;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding: 0.5rem 0;
    }
    
    .order-label {
        font-weight: 500;
        color: #333;
    }
    
    .order-value {
        color: #666;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: bold;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .btn-back {
        margin-top: 1rem;
        padding: 0.75rem 1.5rem;
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        display: inline-block;
    }
    
    .btn-back:hover {
        background-color: #764ba2;
    }
</style>
@endsection

@section('content')
<div class="order-detail">
    <div class="order-header">
        <h1>Commande pour {{ $order->user->email }}</h1>
    </div>
    
    <div class="order-item">
        <span class="order-label">Album : </span>
        <span class="order-value">{{ $order->album->title }}</span>
    </div>
    
    <div class="order-item">
        <span class="order-label">Artiste : </span>
        <span class="order-value">{{ $order->album->artist_name }}</span>
    </div>
    
    <div class="order-item">
        <span class="order-label">Prix : </span>
        <span class="order-value">{{ number_format($order->total_price, 0) }} Ar</span>
    </div>
    
    <div class="order-item">
        <span class="order-label">Statut : </span>
                <span class="status-badge status-{{ strtolower($order->status) }}">{{ __('status.' . strtolower($order->status)) }}</span>
    </div>
    
    <div class="order-item">
        <span class="order-label">Date : </span>
        <span class="order-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
    </div>
    
    <a href="{{ route('orders.index') }}" class="btn-back">← Retour aux commandes</a>
</div>
@endsection
