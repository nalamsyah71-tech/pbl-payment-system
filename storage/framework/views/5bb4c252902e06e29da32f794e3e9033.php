
<?php $__env->startSection('title', 'Edit Kelas'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('kelas.index')); ?>" class="hover:text-gray-700">Kelas</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Edit</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Edit Kelas</h1>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        
        <form action="<?php echo e(route('kelas.update', ['kela' => $kela->id])); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pelatihan <span class="text-red-500">*</span></label>
                <select name="pelatihan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($p->id); ?>" <?php echo e(old('pelatihan_id', $kela->pelatihan_id) == $p->id ? 'selected' : ''); ?>>
                            <?php echo e($p->kejuruan->nama); ?> › <?php echo e($p->nama); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <div>
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" value="<?php echo e(old('nama_kelas', $kela->nama_kelas)); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" value="<?php echo e(old('tgl_mulai', $kela->tgl_mulai->format('Y-m-d'))); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" value="<?php echo e(old('tgl_selesai', $kela->tgl_selesai->format('Y-m-d'))); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>Hari Efektif</label>
                    <input type="number" name="hari_efektif" value="<?php echo e(old('hari_efektif', $kela->hari_efektif)); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label>MAK Pulsa</label>
                    <input type="text" name="mak_pulsa" value="<?php echo e(old('mak_pulsa', $kela->mak_pulsa)); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>MAK Asuransi</label>
                    <input type="text" name="mak_asuransi" value="<?php echo e(old('mak_asuransi', $kela->mak_asuransi)); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label>MAK Uang Saku</label>
                    <input type="text" name="mak_uang_saku" value="<?php echo e(old('mak_uang_saku', $kela->mak_uang_saku)); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm">Update</button>
                <a href="<?php echo e(route('kelas.index')); ?>" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/kelas/edit.blade.php ENDPATH**/ ?>