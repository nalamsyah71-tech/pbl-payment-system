
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <span class="font-semibold text-slate-700">Nizar</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Dashboard</h1>
            <p class="text-sm text-slate-500 mt-0.5">Ringkasan sistem pembayaran peserta pelatihan</p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="<?php echo e(route('pembayaran-pulsa.create')); ?>"
               class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-xl text-white shadow-md transition-all hover:shadow-lg active:scale-95"
               style="background: linear-gradient(135deg, #6366f1, #818cf8);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Bayar Baru
            </a>
        </div>
    </div>

    
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <?php
        $statCards = [
            ['label'=>'Total Peserta','value'=>number_format($stats['total_peserta']),'unit'=>'orang','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','color'=>'from-violet-500 to-purple-600','bg'=>'bg-violet-50','text'=>'text-violet-700'],
            ['label'=>'Total Kelas','value'=>number_format($stats['total_kelas']),'unit'=>'kelas','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'from-blue-500 to-cyan-500','bg'=>'bg-blue-50','text'=>'text-blue-700'],
            ['label'=>'Pembayaran Pulsa','value'=>'Rp '.number_format($stats['total_pulsa'],0,',','.'),'unit'=>'total','icon'=>'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z','color'=>'from-indigo-500 to-blue-600','bg'=>'bg-indigo-50','text'=>'text-indigo-700'],
            ['label'=>'Pembayaran Asuransi','value'=>'Rp '.number_format($stats['total_asuransi'],0,',','.'),'unit'=>'total','icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','color'=>'from-emerald-500 to-green-600','bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
            ['label'=>'Uang Saku','value'=>'Rp '.number_format($stats['total_uang_saku'],0,',','.'),'unit'=>'total','icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z','color'=>'from-amber-500 to-orange-500','bg'=>'bg-amber-50','text'=>'text-amber-700'],
            ['label'=>'Total Transaksi','value'=>number_format($stats['jumlah_pembayaran']),'unit'=>'transaksi','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','color'=>'from-pink-500 to-rose-500','bg'=>'bg-pink-50','text'=>'text-pink-700'],
        ];
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $statCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="bg-white rounded-2xl border border-slate-100 p-4 card-hover shadow-sm relative overflow-hidden">
            <div class="absolute -right-3 -top-3 w-16 h-16 rounded-full opacity-8 <?php echo e($card['bg']); ?>"></div>
            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3 bg-gradient-to-br <?php echo e($card['color']); ?> shadow-sm">
                <svg class="w-4.5 h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($card['icon']); ?>"/>
                </svg>
            </div>
            <p class="text-xs font-medium text-slate-500 mb-1 leading-tight"><?php echo e($card['label']); ?></p>
            <p class="text-base font-extrabold text-slate-800 leading-tight truncate"><?php echo e($card['value']); ?></p>
            <p class="text-xs <?php echo e($card['text']); ?> font-medium mt-0.5"><?php echo e($card['unit']); ?></p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        
        <div class="xl:col-span-1">
            <h2 class="text-sm font-bold text-slate-700 mb-3">Aksi Cepat</h2>
            <div class="space-y-2">
                <?php
                $quickActions = [
                    ['href'=>route('pembayaran-pulsa.create'),'icon'=>'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z','label'=>'Input Pulsa Internet','sub'=>'Pembayaran pulsa peserta','color'=>'from-indigo-500 to-blue-500','bg'=>'bg-indigo-50','text'=>'text-indigo-700'],
                    ['href'=>route('pembayaran-asuransi.create'),'icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','label'=>'Input Asuransi BPJS','sub'=>'Pembayaran premi asuransi','color'=>'from-emerald-500 to-green-500','bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
                    ['href'=>route('pembayaran-uang-saku.create'),'icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z','label'=>'Input Uang Saku','sub'=>'Distribusi uang saku harian','color'=>'from-amber-500 to-orange-500','bg'=>'bg-amber-50','text'=>'text-amber-700'],
                    ['href'=>route('peserta.create'),'icon'=>'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z','label'=>'Tambah Peserta','sub'=>'Daftarkan peserta baru','color'=>'from-violet-500 to-purple-500','bg'=>'bg-violet-50','text'=>'text-violet-700'],
                ];
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a href="<?php echo e($qa['href']); ?>"
                   class="flex items-center gap-3 bg-white border border-slate-100 rounded-xl p-3.5 card-hover shadow-sm group">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 bg-gradient-to-br <?php echo e($qa['color']); ?> shadow-sm">
                        <svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($qa['icon']); ?>"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800"><?php echo e($qa['label']); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($qa['sub']); ?></p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-400 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        
        <div class="xl:col-span-2">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-bold text-slate-700">Transaksi Terbaru</h2>
                <span class="text-xs text-slate-400">10 terakhir</span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentPayments->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/70">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Kuitansi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Kelas</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $typeConfig = [
                                    'Pulsa' => ['bg'=>'bg-indigo-100','text'=>'text-indigo-700'],
                                    'Asuransi' => ['bg'=>'bg-emerald-100','text'=>'text-emerald-700'],
                                    'Uang Saku' => ['bg'=>'bg-amber-100','text'=>'text-amber-700'],
                                ];
                                $tc = $typeConfig[$payment['type']] ?? ['bg'=>'bg-slate-100','text'=>'text-slate-700'];
                            ?>
                            <tr class="table-row hover:bg-slate-50">
                                <td class="px-4 py-3 font-mono text-xs font-semibold text-slate-700"><?php echo e($payment['no_kuitansi']); ?></td>
                                <td class="px-4 py-3">
                                    <span class="badge <?php echo e($tc['bg']); ?> <?php echo e($tc['text']); ?>"><?php echo e($payment['type']); ?></span>
                                </td>
                                <td class="px-4 py-3 text-slate-600 hidden sm:table-cell text-xs"><?php echo e($payment['kelas']); ?></td>
                                <td class="px-4 py-3 text-right font-bold text-slate-800 text-xs">Rp <?php echo e(number_format($payment['total'],0,',','.')); ?></td>
                                <td class="px-4 py-3 text-center text-xs text-slate-500 hidden md:table-cell">
                                    <?php echo e(\Carbon\Carbon::parse($payment['tgl'])->format('d/m/Y')); ?>

                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-semibold">Belum ada transaksi</p>
                    <p class="text-slate-400 text-sm mt-1">Mulai buat pembayaran pertama</p>
                    <a href="<?php echo e(route('pembayaran-pulsa.create')); ?>"
                       class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        Buat Pembayaran →
                    </a>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Project PBL final\pbl-payment-system\resources\views/dashboard.blade.php ENDPATH**/ ?>