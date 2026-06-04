@extends('layouts.app')
@section('title', 'Input Pembayaran Pulsa')
@section('breadcrumb')
    <span class="font-semibold text-slate-700">Pembayaran Pulsa</span>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Form Pembayaran Pulsa</h2>
        
        <form method="POST" action="{{ route('pembayaran-pulsa.store') }}" id="formPulsa">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Kelas</label>
                <select id="kelas_id" name="kelas_id" class="input-field w-full" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4" id="peserta-container" style="display: none;">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Peserta</label>
                <select id="peserta_id_select" class="input-field w-full">
                    <option value="">-- Pilih Peserta --</option>
                </select>
            </div>
            
            <div id="loading" style="display: none;" class="mb-4 text-center text-indigo-600">
                Memuat data peserta...
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Total Uang (Rp)</label>
                <input type="number" name="total_uang" class="input-field w-full" required min="1000">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal SPBY</label>
                <input type="date" name="tgl_spby" class="input-field w-full" value="{{ date('Y-m-d') }}" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3" class="input-field w-full"></textarea>
            </div>
            
            <!-- HIDDEN INPUT untuk peserta_id -->
            <input type="hidden" name="peserta_id" id="hidden_peserta_id" value="">
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-semibold py-2 rounded-lg hover:shadow-lg transition-all">
                    Simpan Pembayaran
                </button>
                <a href="{{ route('pembayaran-pulsa.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var kelasSelect = document.getElementById('kelas_id');
    var pesertaSelect = document.getElementById('peserta_id_select');
    var hiddenPesertaId = document.getElementById('hidden_peserta_id');
    var pesertaContainer = document.getElementById('peserta-container');
    var loading = document.getElementById('loading');
    
    kelasSelect.addEventListener('change', function() {
        var kelasId = this.value;
        
        if (kelasId === '') {
            pesertaContainer.style.display = 'none';
            hiddenPesertaId.value = '';
            return;
        }
        
        loading.style.display = 'block';
        pesertaContainer.style.display = 'none';
        
        fetch('/api/peserta/by-kelas/' + kelasId)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                pesertaSelect.innerHTML = '<option value="">-- Pilih Peserta --</option>';
                
                for (var i = 0; i < data.length; i++) {
                    var option = document.createElement('option');
                    option.value = data[i].id;
                    option.textContent = data[i].nama + ' - ' + (data[i].no_hp || '-');
                    pesertaSelect.appendChild(option);
                }
                
                loading.style.display = 'none';
                pesertaContainer.style.display = 'block';
            })
            .catch(function(error) {
                console.log('Error:', error);
                loading.style.display = 'none';
                alert('Gagal memuat data peserta');
            });
    });
    
    // Saat peserta dipilih, update hidden input
    pesertaSelect.addEventListener('change', function() {
        hiddenPesertaId.value = this.value;
        console.log('Peserta ID tersimpan:', hiddenPesertaId.value);
    });
});
</script>
@endsection