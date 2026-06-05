<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Pulsa - <?php echo e($kelas->nama_kelas); ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11px; margin: 15px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #1e3a5f; padding-bottom: 10px; }
        .header h1 { font-size: 15px; margin: 0 0 4px; color: #1e3a5f; }
        .header p { margin: 2px 0; color: #555; }
        .info-grid { display: table; width: 100%; margin-bottom: 12px; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; width: 140px; font-weight: bold; color: #333; padding: 3px 0; }
        .info-value { display: table-cell; padding: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #aaa; padding: 5px 7px; }
        th { background-color: #1e3a5f; color: white; font-weight: bold; text-align: center; font-size: 10px; }
        td { text-align: center; }
        td.text-left { text-align: left; }
        td.text-right { text-align: right; }
        tr:nth-child(even) { background-color: #f7f8fc; }
        tfoot tr td { background-color: #e8edf5; font-weight: bold; }
        .signature { margin-top: 30px; width: 100%; }
        .sign-table { width: 100%; }
        .sign-cell { width: 33%; text-align: center; vertical-align: top; }
        .sign-line { margin-top: 50px; border-top: 1px solid #333; width: 80%; margin-left: auto; margin-right: auto; }
        .footer { margin-top: 15px; text-align: center; font-size: 9px; color: #888; border-top: 1px solid #ddd; padding-top: 5px; }
        .badge { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 9px; font-weight: bold; }
        .badge-empty { background: #fee2e2; color: #b91c1c; }
        .badge-has { background: #dcfce7; color: #15803d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAFTAR PENERIMA BANTUAN PULSA INTERNET</h1>
        <p><?php echo e($kelas->pelatihan->nama ?? '-'); ?> &nbsp;|&nbsp; Kelas: <strong><?php echo e($kelas->nama_kelas); ?></strong></p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kejuruan): ?>
        <p>Kejuruan: <?php echo e($kejuruan->nama); ?> &nbsp;|&nbsp; MAK: <?php echo e($kelas->mak_pulsa ?? '-'); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <p>Tanggal Cetak: <?php echo e($tanggal_cetak->format('d F Y, H:i')); ?></p>
    </div>

    <table class="info-grid" style="border: none; margin-bottom: 12px;">
        <tr class="info-row">
            <td class="info-label" style="border:none;">Periode Kelas</td>
            <td class="info-value" style="border:none;">: <?php echo e(\Carbon\Carbon::parse($kelas->tgl_mulai)->format('d/m/Y')); ?> – <?php echo e(\Carbon\Carbon::parse($kelas->tgl_selesai)->format('d/m/Y')); ?></td>
            <td class="info-label" style="border:none;">Hari Efektif</td>
            <td class="info-value" style="border:none;">: <?php echo e(number_format($kelas->hari_efektif)); ?> hari</td>
        </tr>
        <tr class="info-row">
            <td class="info-label" style="border:none;">Jumlah Terdata</td>
            <td class="info-value" style="border:none;">: <?php echo e($pembayaranList->count()); ?> orang</td>
            <td class="info-label" style="border:none;">Total Keseluruhan</td>
            <td class="info-value" style="border:none; font-weight:bold; color:#1e3a5f;">: Rp <?php echo e(number_format($totalKeseluruhan, 0, ',', '.')); ?></td>
        </tr>
    </table>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pembayaranList->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:16%">No. Kuitansi</th>
                <th style="width:28%">Nama Peserta</th>
                <th style="width:15%">NIK</th>
                <th style="width:13%">No. HP</th>
                <th style="width:10%">Tgl. Bayar</th>
                <th style="width:14%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pembayaranList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->no_kuitansi); ?></td>
                <td class="text-left"><?php echo e($item->peserta?->nama ?? '-'); ?></td>
                <td><?php echo e($item->peserta?->nik ?? '-'); ?></td>
                <td><?php echo e($item->peserta?->no_hp ?? '-'); ?></td>
                <td><?php echo e($item->tgl_spby->format('d/m/Y')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($item->total_uang, 0, ',', '.')); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"><strong>TOTAL KESELURUHAN:</strong></td>
                <td class="text-right"><strong>Rp <?php echo e(number_format($totalKeseluruhan, 0, ',', '.')); ?></strong></td>
            </tr>
        </tfoot>
    </table>
    <?php else: ?>
    <p style="text-align:center; padding: 20px; color: #b91c1c;">Belum ada data pembayaran pulsa untuk kelas ini.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <table class="sign-table" style="border: none; margin-top: 35px;">
        <tr>
            <td class="sign-cell" style="border:none;">
                <p>Mengetahui,</p>
                <p>Kepala Pelatihan</p>
                <div class="sign-line"></div>
            </td>
            <td class="sign-cell" style="border:none;"></td>
            <td class="sign-cell" style="border:none;">
                <p>Dibuat oleh,</p>
                <p>Bendahara</p>
                <div class="sign-line"></div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari Sistem Pembayaran &mdash; <?php echo e($tanggal_cetak->format('d/m/Y H:i')); ?>

    </div>
</body>
</html><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/pdf/pulsa-kelas.blade.php ENDPATH**/ ?>