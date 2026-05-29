@extends('layouts.app')
@section('title', 'Tambah Pembayaran Asuransi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    <span class="mx-2">/</span>
    <a href="{{ route('pembayaran-asuransi.index') }}" class="hover:text-gray-700">Pembayaran Asuransi</a>
    <span class="mx-2">/</span>
    <span class="text-gray-800 font-medium">Tambah</span>
@endsection

@section('content')
    <livewire:form-asuransi />
@endsection