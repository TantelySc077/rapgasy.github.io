@extends('layout.app')

@section('title', 'Paiement')

@section('styles')
<style>
    .payment-container {
        max-width: 600px;
        margin: 2rem auto;
    }
    
    .payment-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .order-summary {
        background-color: #f5f5f5;
        padding: 1.5rem;
        border-radius: 5px;
        margin-bottom: 2rem;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .summary-total {
        border-top: 2px solid #ddd;
        padding-top: 1rem;
        font-size: 1.2rem;
        font-weight: bold;
        color: #667eea;
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
    
    select, input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }
    
    select:focus, input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
    }
    
    .payment-info {
        background: #e7f3ff;
        border-left: 4px solid #667eea;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 5px;
    }
    
    .payment-info h3 {
        margin-top: 0;
        color: #333;
    }
    
    .payment-details {
        font-size: 0.9rem;
        line-height: 1.8;
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
</style>
@endsection

@section('content')
<div class="payment-container">
    <div class="payment-card">
        <h1>Paiement de l'album</h1>
        
        <div class="order-summary">
            <div class="summary-item">
                <span>Album:</span>
                <strong>{{ $order->album->title }}</strong>
            </div>
            <div class="summary-item">
                <span>Artiste:</span>
                <strong>{{ $order->album->artist_name }}</strong>
            </div>
            <div class="summary-item summary-total">
                <span>Montant à payer:</span>
                <span>{{ number_format($order->total_price, 0) }} Ar</span>
            </div>
        </div>
        
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            
            <div class="form-group">
                <label for="method">Mode de paiement</label>
                <select id="method" name="method" required onchange="updatePaymentInfo()">
                    <option value="">Sélectionnez un mode de paiement</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method }}">{{ $method }}</option>
                    @endforeach
                </select>
                @error('method')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div id="paymentDetails" style="display: none;">
                <div class="payment-info">
                    <h3>Mode de paiement</h3>
                    <div class="payment-details">
                        <div id="mvola" style="display: none;">
                            <strong>MVola : </strong><br>
                            Numéro: <strong>038 70 562 18 (RANDRINARIVO Solofonomenjanahary Tantely)</strong><br>
                            Montant: {{ number_format($order->total_price, 0) }} Ar
                        </div>
                        <div id="orange" style="display: none;">
                            <strong>Orange Money : </strong><br>
                            Numéro: <strong>032 20 677 65 (RANDRINARIVO Solofonomenjanahary Tantely)</strong><br>
                            Montant: {{ number_format($order->total_price, 0) }} Ar
                        </div>
                        <div id="airtel" style="display: none;">
                            <strong>Airtel Money : </strong><br>
                            Numéro: <strong>033 10 755 79 (RANDRINARIVO Solofonomenjanahary Tantely)</strong><br>
                            Montant: {{ number_format($order->total_price, 0) }} Ar
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="reference">Référence de paiement</label>
                <input type="text" id="reference" name="reference" placeholder="Copiez la référence de la transaction" required>
                @error('reference')
                    <p style="color: red; font-size: 0.9rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="btn-submit">Confirmer le paiement</button>
        </form>
    </div>
</div>

<script>
function updatePaymentInfo() {
    const method = document.getElementById('method').value;
    const details = document.getElementById('paymentDetails');
    
    document.getElementById('mvola').style.display = 'none';
    document.getElementById('orange').style.display = 'none';
    document.getElementById('airtel').style.display = 'none';
    
    if (method === 'MVola') {
        document.getElementById('mvola').style.display = 'block';
        details.style.display = 'block';
    } else if (method === 'Orange Money') {
        document.getElementById('orange').style.display = 'block';
        details.style.display = 'block';
    } else if (method === 'Airtel Money') {
        document.getElementById('airtel').style.display = 'block';
        details.style.display = 'block';
    } else {
        details.style.display = 'none';
    }
}
</script>
@endsection
