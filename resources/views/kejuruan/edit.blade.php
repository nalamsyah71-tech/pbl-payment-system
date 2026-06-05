@extends('layouts.app')
@section('title', 'Edit Kejuruan')
@section('breadcrumb')
    <a href="{{ route('kejuruan.index') }}" class="hover:text-gray-700">Kejuruan</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Edit</span>
@endsection
@section('content')
<div class="max-w-lg">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Edit Kejuruan</h1>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('kejuruan.update', $kejuruan) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kejuruan <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $kejuruan->nama) }}"
                    class="w-full px-3 py-2 border @error('nama') border-red-500 @else @enderror rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Update
                </button>
                <a href="{{ route('kejuruan.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection