
<?php $__env->startSection('title', 'Edit Pelatihan'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('pelatihan.index')); ?>" class="hover:text-gray-700">Pelatihan</a>
    <span class="mx-2">/</span><span class="font-medium text-gray-800">Edit</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-lg">
    <h1 class="text-xl font-bold text-gray-900 mb-5">Edit Pelatihan</h1>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="<?php echo e(route('pelatihan.update', $pelatihan)); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kejuruan <span class="text-red-500">*</span></label>
                <select name="kejuruan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kejuruans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($k->id); ?>" <?php echo e(old('kejuruan_id', $pelatihan->kejuruan_id) == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelatihan <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="<?php echo e(old('nama', $pelatihan->nama)); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Update</button>
                <a href="<?php echo e(route('pelatihan.index')); ?>" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/pelatihan/edit.blade.php ENDPATH**/ ?>