
<?php $__env->startSection('title', 'Detail Pembayaran Asuransi BPJS'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('pembayaran-asuransi.index')); ?>" class="hover:text-gray-700">Pembayaran Asuransi</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Detail</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail Pembayaran Asuransi BPJS</h1>
            <p class="text-sm text-gray-500 mt-0.5"><?php echo e($pembayaranAsuransi->no_kuitansi); ?></p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('pembayaran-asuransi.index')); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm">Kembali</a>
        </div>
    </div>

    <?php
        $detailPeserta = $pembayaranAsuransi->detail_peserta;
        if (is_string($detailPeserta)) {
            $detailPeserta = json_decode($detailPeserta, true);
        }
        if (!is_array($detailPeserta)) {
            $detailPeserta = [];
        }
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 text-sm border-b pb-3 mb-4">Informasi Pembayaran</h2>
            <div class="space-y-3">
                <div class="flex"><span class="w-32 text-gray-500 text-sm">No. Kuitansi</span><span class="font-mono text-sm"><?php echo e($pembayaranAsuransi->no_kuitansi); ?></span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">No. SK</span><span><?php echo e($pembayaranAsuransi->no_sk ?? '-'); ?></span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Tanggal SPBY</span><span><?php echo e($pembayaranAsuransi->tgl_spby->format('d/m/Y')); ?></span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Kelas</span><span><?php echo e($pembayaranAsuransi->kelas->nama_kelas ?? '-'); ?></span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Pelatihan</span><span><?php echo e($pembayaranAsuransi->kelas->pelatihan->nama ?? '-'); ?></span></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 text-sm border-b pb-3 mb-4">Ringkasan</h2>
            <div class="space-y-2">
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Jumlah Peserta</span><span><?php echo e($pembayaranAsuransi->jumlah_peserta ?? count($detailPeserta)); ?> orang</span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Total Premi</span><span class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($pembayaranAsuransi->total_premi, 0, ',', '.')); ?></span></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-100">
            <h2 class="font-semibold text-sm">Daftar Peserta</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama Peserta</th>
                        <th class="px-4 py-2 text-left">No HP</th>
                        <th class="px-4 py-2 text-right">Premi (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $detailPeserta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?php echo e($idx + 1); ?></td>
                        <td class="px-4 py-2"><?php echo e($p['nama'] ?? '-'); ?></td>
                        <td class="px-4 py-2"><?php echo e($p['no_hp'] ?? '-'); ?></td>
                        <td class="px-4 py-2 text-right">Rp <?php echo e(number_format($p['nominal'] ?? 0, 0, ',', '.')); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada data peserta</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/pembayaran/asuransi/show.blade.php ENDPATH**/ ?>