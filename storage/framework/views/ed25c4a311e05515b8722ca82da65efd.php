
<?php $__env->startSection('title', 'Detail Pembayaran Uang Saku'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <span class="font-semibold text-slate-700">Detail Pembayaran</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h1 class="text-lg font-bold text-slate-800">Detail Pembayaran Uang Saku</h1>
            <p class="text-xs text-slate-500 mt-0.5">No. Kuitansi: <?php echo e($pembayaranUangSaku->no_kuitansi); ?></p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 rounded-xl p-4">
                    <h2 class="font-semibold text-sm text-slate-700 border-b pb-2 mb-3">Informasi Kelas</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex"><span class="w-28 text-slate-500">Kelas</span><span><?php echo e($pembayaranUangSaku->kelas->nama_kelas ?? '-'); ?></span></div>
                        <div class="flex"><span class="w-28 text-slate-500">Pelatihan</span><span><?php echo e($pembayaranUangSaku->kelas->pelatihan->nama ?? '-'); ?></span></div>
                        <div class="flex"><span class="w-28 text-slate-500">Tanggal SPBY</span><span><?php echo e(\Carbon\Carbon::parse($pembayaranUangSaku->tgl_spby)->format('d/m/Y')); ?></span></div>
                    </div>
                </div>
                
                <div class="bg-slate-50 rounded-xl p-4">
                    <h2 class="font-semibold text-sm text-slate-700 border-b pb-2 mb-3">Ringkasan</h2>
                    <div class="space-y-2 text-sm">
                        <?php
                            $detailPeserta = $pembayaranUangSaku->detail_peserta;
                            // Jika masih string JSON, decode dulu
                            if (is_string($detailPeserta)) {
                                $detailPeserta = json_decode($detailPeserta, true);
                            }
                            if (!is_array($detailPeserta)) {
                                $detailPeserta = [];
                            }
                        ?>
                        <div class="flex"><span class="w-28 text-slate-500">Total Peserta</span><span><?php echo e(count($detailPeserta)); ?> orang</span></div>
                        <div class="flex"><span class="w-28 text-slate-500">Total Uang</span><span class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($pembayaranUangSaku->total_uang, 0, ',', '.')); ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-slate-100">
            <div class="px-6 py-3 bg-slate-50/50 border-b border-slate-100">
                <h2 class="font-semibold text-sm text-slate-700">Daftar Penerima Uang Saku</h2>
            </div>
            
            <?php
                $detailPeserta = $pembayaranUangSaku->detail_peserta;
                if (is_string($detailPeserta)) {
                    $detailPeserta = json_decode($detailPeserta, true);
                }
                if (!is_array($detailPeserta)) {
                    $detailPeserta = [];
                }
            ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($detailPeserta) > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500">Nama Peserta</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500">Hari Hadir</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detailPeserta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3"><?php echo e($idx + 1); ?></td>
                            <td class="px-4 py-3 font-medium"><?php echo e($p['nama'] ?? '-'); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($p['hari_kehadiran'] ?? 0); ?></td>
                            <td class="px-4 py-3 text-right font-semibold">Rp <?php echo e(number_format($p['nominal'] ?? 0, 0, ',', '.')); ?></td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-8 text-slate-500 text-sm">
                Tidak ada data peserta
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 flex justify-between">
            <a href="<?php echo e(route('pembayaran-uang-saku.index')); ?>" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800">
                ← Kembali
            </a>
            <div class="flex gap-2">
                <a href="<?php echo e(route('pembayaran-uang-saku.pdf', $pembayaranUangSaku)); ?>" class="px-4 py-2 text-sm font-medium bg-red-500 text-white rounded-lg hover:bg-red-600">
                    PDF
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/pembayaran/uang_saku/show.blade.php ENDPATH**/ ?>