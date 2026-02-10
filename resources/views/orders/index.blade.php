@extends('layout.app')

@section('title', 'Mes commandes')

@section('styles')
<style>
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .orders-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .orders-table th {
        padding: 1rem;
        text-align: left;
        font-weight: bold;
    }
    
    .orders-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .orders-table tbody tr:hover {
        background-color: #f5f5f5;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.9rem;
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
    
    .btn-view {
        padding: 0.5rem 1rem;
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-view:hover {
        background-color: #764ba2;
    }
    
    .empty-message {
        text-align: center;
        padding: 2rem;
        color: #666;
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
<h1>Mes Commandes</h1>

@if($orders->count() > 0)
    <table class="orders-table">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Album</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->user->email }}</td>
                    <td>{{ $order->album->title }}</td>
                    <td>{{ number_format($order->total_price, 0) }} Ar</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($order->status) }}">
                            {{ __('status.' . strtolower($order->status)) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($order->payment)
                            @if($order->payment->status === 'approved')
                                <a href="{{ route('payments.download', $order->payment->id) }}" class="btn-view">Télécharger</a>
                            @elseif($order->payment->status === 'pending')
                                <a href="{{ route('payments.show', $order->payment->id) }}" class="btn-view">Voir</a>
                            @else
                                <span class="btn-view" style="background:#e74c3c; cursor:default;">{{ __('orders.retry') }}</span>
                                <a href="{{ route('payments.create', $order->id) }}" class="btn-view" style="margin-left:0.5rem;">{{ __('orders.pay') }}</a>
                            @endif
                        @else
                            <a href="{{ route('payments.create', $order->id) }}" class="btn-view">{{ __('orders.refused') }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination">
        {{ $orders->links() }}
    </div>
@else
    <div class="empty-message">
        <p>Vous n'avez pas encore de commande.</p>
        <a href="{{ route('albums.index') }}" class="btn-view" style="margin-top: 1rem;">Voir les albums</a>
    </div>
@endif
@endsection
