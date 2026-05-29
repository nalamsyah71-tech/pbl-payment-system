@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Form Pembayaran</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('payment.store') }}">
                @csrf
                <div class="form-group">
                    <label>Jumlah Pembayaran</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Bayar</button>
            </form>
        </div>
    </div>
</div>
@endsection