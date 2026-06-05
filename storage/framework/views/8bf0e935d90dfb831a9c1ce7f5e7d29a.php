
<?php $__env->startSection('title', 'Detail Kelas'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('kelas.index')); ?>" class="hover:text-gray-700">Kelas</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Detail</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail Kelas</h1>
            <p class="text-sm text-gray-500 mt-0.5"><?php echo e($kela->nama_kelas); ?></p>
        </div>
        <div class="flex gap-2">
            
            <a href="<?php echo e(route('kelas.edit', ['kela' => $kela->id])); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Edit Kelas</a>
            <a href="<?php echo e(route('peserta.create', ['kelas_id' => $kela->id])); ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700">+ Tambah Peserta</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 text-sm border-b pb-3 mb-4">Informasi Kelas</h2>
            <div class="space-y-3">
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Pelatihan</span><span class="text-gray-800"><?php echo e($kela->pelatihan->nama); ?></span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Kejuruan</span><span class="text-gray-800"><?php echo e($kela->pelatihan->kejuruan->nama); ?></span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Periode</span><span class="text-gray-800"><?php echo e(\Carbon\Carbon::parse($kela->tgl_mulai)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($kela->tgl_selesai)->format('d/m/Y')); ?></span></div>
                <div class="flex"><span class="w-32 text-gray-500 text-sm">Hari Efektif</span><span class="text-gray-800 font-semibold"><?php echo e(number_format($kela->hari_efektif)); ?> hari</span></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 text-sm border-b pb-3 mb-4">MAK (Mata Anggaran Kegiatan)</h2>
            <div class="space-y-3">
                <div class="flex"><span class="w-28 text-gray-500 text-sm">MAK Pulsa</span><span class="font-mono text-xs text-gray-700"><?php echo e($kela->mak_pulsa ?? '-'); ?></span></div>
                <div class="flex"><span class="w-28 text-gray-500 text-sm">MAK Asuransi</span><span class="font-mono text-xs text-gray-700"><?php echo e($kela->mak_asuransi ?? '-'); ?></span></div>
                <div class="flex"><span class="w-28 text-gray-500 text-sm">MAK Uang Saku</span><span class="font-mono text-xs text-gray-700"><?php echo e($kela->mak_uang_saku ?? '-'); ?></span></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800 text-sm">Daftar Peserta (<?php echo e($kela->pesertas->count()); ?> peserta)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 font-semibold uppercase">
                        <th class="px-4 py-2.5 text-left">No</th>
                        <th class="px-4 py-2.5 text-left">NIK</th>
                        <th class="px-4 py-2.5 text-left">Nama</th>
                        <th class="px-4 py-2.5 text-left">No HP</th>
                        <th class="px-4 py-2.5 text-right">Hari Hadir</th>
                        <th class="px-4 py-2.5 text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $kela->pesertas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2.5 text-gray-500"><?php echo e($loop->iteration); ?></td>
                        <td class="px-4 py-2.5 font-mono text-xs text-gray-600"><?php echo e($p->nik); ?></td>
                        <td class="px-4 py-2.5 font-medium text-gray-900"><?php echo e($p->nama); ?></td>
                        <td class="px-4 py-2.5 text-gray-500"><?php echo e($p->no_hp); ?></td>
                        <td class="px-4 py-2.5 text-right font-semibold"><?php echo e($p->hari_kehadiran); ?> hari</td>
                        <td class="px-4 py-2.5 text-center">
                            <a href="<?php echo e(route('peserta.edit', $p)); ?>" class="text-blue-600 hover:text-blue-800">Edit</a>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada peserta</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/kelas/show.blade.php ENDPATH**/ ?>