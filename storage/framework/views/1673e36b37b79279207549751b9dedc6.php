
<?php $__env->startSection('title', 'Input Pembayaran Uang Saku'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <span class="font-semibold text-slate-700">Pembayaran Uang Saku</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Form Pembayaran Uang Saku</h2>
        
        <form method="POST" action="<?php echo e(route('pembayaran-uang-saku.store')); ?>" id="formUangSaku">
            <?php echo csrf_field(); ?>
            
            <!-- Pilih Kelas -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Kelas <span class="text-red-500">*</span></label>
                <select id="kelas_id" name="kelas_id" class="input-field w-full" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($kelas->id); ?>"><?php echo e($kelas->nama_kelas); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            
            <!-- Pilih Peserta -->
            <div class="mb-4" id="peserta-container" style="display: none;">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Peserta <span class="text-red-500">*</span></label>
                <select id="peserta_id" name="peserta_id" class="input-field w-full" required>
                    <option value="">-- Pilih Peserta --</option>
                </select>
            </div>
            
            <div id="loading" style="display: none;" class="mb-4 text-center text-indigo-600">
                <svg class="spinner w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Memuat data peserta...
            </div>
            
            <!-- No Kuitansi (MANUAL - TIDAK OTOMATIS) -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Kuitansi <span class="text-red-500">*</span></label>
                <input type="text" id="no_kuitansi" name="no_kuitansi" class="input-field w-full" placeholder="Contoh: US/20240604/001" required>
                <p class="text-xs text-slate-500 mt-1">Masukkan nomor kuitansi secara manual (harus unik)</p>
            </div>
            
            <!-- Hari Kehadiran -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Hari Kehadiran <span class="text-red-500">*</span></label>
                <input type="number" id="hari_kehadiran" name="hari_kehadiran" class="input-field w-full" min="1" max="31" required placeholder="Jumlah hari kehadiran (1-31)">
                <p class="text-xs text-slate-500 mt-1">Jumlah hari kehadiran peserta (1-31 hari) x Rp 20.000</p>
            </div>
            
            <!-- Total Uang (Otomatis) -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Total Uang (Rp)</label>
                <input type="number" id="total_uang" name="total_uang" class="input-field w-full bg-slate-100" readonly required>
                <p class="text-xs text-slate-500 mt-1">Total akan terisi otomatis: (Hari Kehadiran × Rp 20.000)</p>
            </div>
            
            <!-- Tanggal SPBY -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal SPBY <span class="text-red-500">*</span></label>
                <input type="date" name="tgl_spby" class="input-field w-full" value="<?php echo e(date('Y-m-d')); ?>" required>
            </div>
            
            <!-- Hidden input untuk detail_peserta (JSON) -->
            <input type="hidden" name="detail_peserta" id="detail_peserta" value="">
            
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-semibold py-2 rounded-lg hover:shadow-lg transition-all">
                    Simpan Pembayaran
                </button>
                <a href="<?php echo e(route('pembayaran-uang-saku.index')); ?>" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var kelasSelect = document.getElementById('kelas_id');
    var pesertaSelect = document.getElementById('peserta_id');
    var pesertaContainer = document.getElementById('peserta-container');
    var loading = document.getElementById('loading');
    var totalUang = document.getElementById('total_uang');
    var hariKehadiran = document.getElementById('hari_kehadiran');
    var noKuitansi = document.getElementById('no_kuitansi');
    var detailPesertaHidden = document.getElementById('detail_peserta');
    
    kelasSelect.addEventListener('change', function() {
        var kelasId = this.value;
        
        if (kelasId === '') {
            pesertaContainer.style.display = 'none';
            pesertaSelect.innerHTML = '<option value="">-- Pilih Peserta --</option>';
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
    
    // Hitung otomatis total uang berdasarkan hari kehadiran
    hariKehadiran.addEventListener('input', function() {
        var tarifPerHari = 20000; // Rp 20.000 per hari
        var hari = parseInt(this.value) || 0;
        var total = hari * tarifPerHari;
        totalUang.value = total;
    });
    
    // Saat submit, siapkan detail_peserta dalam format JSON
    document.getElementById('formUangSaku').addEventListener('submit', function(e) {
        var pesertaId = pesertaSelect.value;
        var pesertaNama = pesertaSelect.options[pesertaSelect.selectedIndex]?.text.split(' - ')[0] || '';
        var pesertaNoHp = pesertaSelect.options[pesertaSelect.selectedIndex]?.text.split(' - ')[1] || '';
        var hari = hariKehadiran.value;
        var nominal = totalUang.value;
        
        var detailPeserta = [{
            id: pesertaId,
            nama: pesertaNama,
            no_hp: pesertaNoHp,
            hari_kehadiran: hari,
            nominal: nominal
        }];
        
        detailPesertaHidden.value = JSON.stringify(detailPeserta);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/pembayaran/uang_saku/create.blade.php ENDPATH**/ ?>