@extends('layout.app')

@section('title', 'Commandes en attente')

@section('styles')
<style>
    .pending-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 2rem;
    }

    .section-title {
        color: #667eea;
        font-size: 1.8rem;
        margin-bottom: 2rem;
        border-bottom: 3px solid #667eea;
        padding-bottom: 1rem;
    }

    .order-card {
        background: #f9f9f9;
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s;
    }

    .order-card:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        background: #f5f7ff;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #ddd;
    }

    .order-id {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }

    .order-date {
        color: #999;
        font-size: 0.9rem;
    }

    .order-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .info-section {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .info-label {
        font-weight: bold;
        color: #666;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        color: #333;
    }

    .album-cover {
        max-width: 100px;
        height: 100px;
        border-radius: 5px;
        object-fit: cover;
        margin-right: 1rem;
    }

    .album-info {
        display: flex;
        align-items: center;
    }

    .album-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .amount {
        font-size: 1.5rem;
        font-weight: bold;
        color: #27ae60;
    }

    .payment-method {
        background: #e8f4f8;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        display: inline-block;
        font-size: 0.9rem;
        color: #0c5460;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-approve, .btn-reject {
        padding: 0.7rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: bold;
        transition: all 0.3s;
    }

    .btn-approve {
        background-color: #27ae60;
        color: white;
    }

    .btn-approve:hover {
        background-color: #229954;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(39, 174, 96, 0.3);
    }

    .btn-reject {
        background-color: #e74c3c;
        color: white;
    }

    .btn-reject:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(231, 76, 60, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #999;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 10px;
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .order-body {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-approve, .btn-reject {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="pending-container">
    <h1 style="color: #333; margin-bottom: 2rem;">✅ Valider les Commandes</h1>

    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-number">{{ $pendingPayments->total() }}</div>
            <div class="stat-label">Commandes en attente</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ number_format($pendingPayments->sum('amount'), 0) }}</div>
            <div class="stat-label">Montant total (Ar)</div>
        </div>
    </div>

    @if($pendingPayments->count() > 0)
        @foreach($pendingPayments as $payment)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <div class="order-id">Commande pour {{ $payment->order->user->email }}</div>
                        <div class="order-date">{{ $payment->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    <span class="badge-pending">⏳ {{ __('status.' . strtolower($payment->status)) }}</span>
                </div>

                <div class="order-body">
                    <!-- Informations Client -->
                    <div class="info-section">
                        <div>
                            <div class="info-label">👤 Client</div>
                            <div class="info-value">{{ $payment->order->user->name }}</div>
                        </div>
                        <div>
                            <div class="info-label">📧 Email</div>
                            <div class="info-value">{{ $payment->order->user->email }}</div>
                        </div>
                    </div>

                    <!-- Informations Album -->
                    <div class="info-section">
                        <div>
                            <div class="info-label">🎵 Album</div>
                            <div class="album-info">
                                @if($payment->order->album->cover_image)
                                    <img src="{{ asset('storage/' . $payment->order->album->cover_image) }}" alt="{{ $payment->order->album->title }}" class="album-cover">
                                @else
                                    <span style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background: #eee; border-radius: 5px; margin-right: 1rem;">🎵</span>
                                @endif
                                <div class="album-details">
                                    <strong>{{ $payment->order->album->title }}</strong>
                                    <small style="color: #666;">{{ $payment->order->album->artist_name }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; padding-top: 1rem; border-top: 1px solid #ddd; margin-bottom: 1rem;">
                    <div>
                        <div class="info-label">💰 Montant : </div>
                        <div class="amount">{{ number_format($payment->amount, 0) }} Ar</div>
                    </div>
                    <div>
                        <div class="info-label">💳 Payement par : </div>
                        <span class="payment-method">{{ $payment->method }}</span>
                    </div>
                    <div>
                        <div class="info-label">🔑 Référence : </div>
                        <div class="info-value">{{ $payment->reference }}</div>
                    </div>
                </div>

                <div class="action-buttons">
                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-approve">✅ Approuver</button>
                    </form>
                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-reject">❌ Rejeter</button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $pendingPayments->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🎉</div>
            <h2>Aucune commande en attente!</h2>
            <p>Toutes les commandes ont été validées.</p>
        </div>
    @endif
</div>
@endsection
