@extends('layouts.app')
@section('title', 'Tambah Pembayaran Pulsa')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <span class="mx-2">/</span>
    <a href="{{ route('pembayaran-pulsa.index') }}" class="hover:text-gray-700">Pembayaran Pulsa</a>
    <span class="mx-2">/</span>
    <span class="text-gray-800 font-medium">Tambah</span>
@endsection

@section('content')
    <livewire:form-pulsa />
@endsection