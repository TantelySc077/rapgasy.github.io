@extends('layout.app')

@section('title', 'Historique des paiements')

@section('styles')
<style>
    .payments-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 2rem;
    }
    
    .payments-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .payments-table th {
        padding: 1rem;
        text-align: left;
        font-weight: bold;
    }
    
    .payments-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .payments-table tbody tr:hover {
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
    
    .status-approved {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .btn-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-approve, .btn-reject {
        padding: 0.4rem 0.8rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: bold;
    }
    
    .btn-approve {
        background-color: #27ae60;
        color: white;
    }
    
    .btn-approve:hover {
        background-color: #229954;
    }
    
    .btn-reject {
        background-color: #e74c3c;
        color: white;
    }
    
    .btn-reject:hover {
        background-color: #c0392b;
    }
    
    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .filter-group {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .filter-group select {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 5px;
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
<h1>Historique des paiements</h1>

<div class="filter-section">
    <div class="filter-group">
        <label>Filtrer par statut:</label>
        <select onchange="window.location.href = this.value">
            <option value="{{ route('admin.payments.history') }}">Tous</option>
            <option value="{{ route('admin.payments.history', ['status' => 'pending']) }}">En attente</option>
            <option value="{{ route('admin.payments.history', ['status' => 'approved']) }}">Approuvés</option>
            <option value="{{ route('admin.payments.history', ['status' => 'rejected']) }}">Rejetés</option>
        </select>
    </div>
</div>

@if($payments->count() > 0)
    <table class="payments-table">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Client</th>
                <th>Album</th>
                <th>Montant</th>
                <th>Méthode</th>
                <th>Référence</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->order->user->email }}</td>
                    <td>{{ $payment->order->user->name }}</td>
                    <td>{{ $payment->order->album->title }}</td>
                    <td>{{ number_format($payment->amount, 0) }} Ar</td>
                    <td>{{ $payment->method }}</td>
                    <td>{{ $payment->reference }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($payment->status) }}">
                            {{ __('status.' . strtolower($payment->status)) }}
                        </span>
                    </td>
                    <td>
                        @if($payment->status === 'pending')
                            <div class="btn-group">
                                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-approve">Approuver</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-reject">Rejeter</button>
                                </form>
                            </div>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination">
        {{ $payments->links() }}
    </div>
@else
    <div style="text-align: center; padding: 2rem;">
        <p>Aucun paiement trouvé.</p>
    </div>
@endif
@endsection
