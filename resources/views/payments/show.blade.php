@extends('layout.app')

@section('title', 'Détails du paiement')

@section('styles')
<style>
    .receipt-container {
        max-width: 600px;
        margin: 2rem auto;
    }
    
    .receipt {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .receipt-header {
        text-align: center;
        border-bottom: 2px solid #667eea;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .receipt-header h1 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-approved {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .receipt-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .receipt-item:last-child {
        border-bottom: none;
    }
    
    .receipt-label {
        font-weight: 500;
        color: #333;
    }
    
    .receipt-value {
        color: #666;
    }
    
    .receipt-total {
        font-size: 1.3rem;
        font-weight: bold;
        color: #667eea;
    }
    
    .message {
        padding: 1rem;
        border-radius: 5px;
        margin-bottom: 1rem;
    }
    
    .message-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }
    
    .btn-download {
        width: 100%;
        padding: 0.75rem;
        background-color: #27ae60;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        margin-top: 1rem;
        display: none;
    }
    
    .btn-download.show {
        display: block;
    }
    
    .btn-download:hover {
        background-color: #229954;
    }
</style>
@endsection

@section('content')
<div class="receipt-container">
    <div class="receipt">
        <div class="receipt-header">
            <h1>Récépissé de paiement</h1>
            <div class="status-badge status-{{ strtolower($payment->status) }}">
                {{ __('status.' . strtolower($payment->status)) }}
            </div>
        </div>
        
        @if($payment->status === 'pending')
            <div class="message message-info">
                ⏳ Votre paiement est en attente de validation de l'administrateur. Vous recevrez une confirmation dans les plus brefs délais.
            </div>
        @elseif($payment->status === 'approved')
            <div class="message" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                ✓ Votre paiement a été approuvé! Vous pouvez maintenant télécharger votre album.
            </div>
        @elseif($payment->status === 'rejected')
            <div class="message" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                ✗ Votre paiement a été rejeté. Veuillez vérifier et réessayer.
            </div>
        @endif
        
        <div class="receipt-item">
            <span class="receipt-label">Numéro de paiement : </span>
            <span class="receipt-value">{{ $payment->order->user->email }}</span>
        </div>
        
        <div class="receipt-item">
            <span class="receipt-label">Album : </span>
            <span class="receipt-value">{{ $payment->order->album->title }}</span>
        </div>
        
        <div class="receipt-item">
            <span class="receipt-label">Artiste : </span>
            <span class="receipt-value">{{ $payment->order->album->artist_name }}</span>
        </div>
        
        <div class="receipt-item">
            <span class="receipt-label">Mode de paiement : </span>
            <span class="receipt-value">{{ $payment->method }}</span>
        </div>
        
        <div class="receipt-item">
            <span class="receipt-label">Référence : </span>
            <span class="receipt-value">{{ $payment->reference }}</span>
        </div>
        
        <div class="receipt-item">
            <span class="receipt-label">Montant : </span>
            <span class="receipt-value receipt-total">{{ number_format($payment->amount, 0) }} Ar</span>
        </div>
        
        <div class="receipt-item">
            <span class="receipt-label">Date : </span>
            <span class="receipt-value">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
        </div>
        
        @if($payment->status === 'approved')
            <a href="{{ route('payments.download', $payment->id) }}" class="btn-download show">⬇️ Télécharger l'album</a>
        @endif
    </div>
</div>
@endsection
