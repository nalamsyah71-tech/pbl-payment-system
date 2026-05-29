@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-success">
        <h4>Pembayaran Berhasil!</h4>
        <p>Terima kasih telah melakukan pembayaran.</p>
        <a href="{{ route('payment.history') }}" class="btn btn-primary">Lihat Riwayat</a>
    </div>
</div>
@endsection