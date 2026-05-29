@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-danger">
        <h4>Pembayaran Gagal!</h4>
        <p>Silakan coba lagi atau hubungi admin.</p>
        <a href="{{ route('payment.create') }}" class="btn btn-primary">Coba Lagi</a>
    </div>
</div>
@endsection