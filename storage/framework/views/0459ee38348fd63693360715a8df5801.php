<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Uang Saku - <?php echo e($kelas->nama_kelas); ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11px; margin: 15px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #92400e; padding-bottom: 10px; }
        .header h1 { font-size: 15px; margin: 0 0 4px; color: #92400e; }
        .header p { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #aaa; padding: 5px 7px; }
        th { background-color: #92400e; color: white; font-weight: bold; text-align: center; font-size: 10px; }
        td { text-align: center; }
        td.text-left { text-align: left; }
        td.text-right { text-align: right; }
        tr:nth-child(even) { background-color: #fffbeb; }
        tfoot tr td { background-color: #fef3c7; font-weight: bold; }
        .sign-cell { width: 33%; text-align: center; vertical-align: top; border: none !important; }
        .sign-line { margin-top: 50px; border-top: 1px solid #333; width: 80%; margin-left: auto; margin-right: auto; }
        .footer { margin-top: 15px; text-align: center; font-size: 9px; color: #888; border-top: 1px solid #ddd; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAFTAR PENERIMA UANG SAKU</h1>
        <p><?php echo e($kelas->pelatihan->nama ?? '-'); ?> &nbsp;|&nbsp; Kelas: <strong><?php echo e($kelas->nama_kelas); ?></strong></p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kejuruan): ?>
        <p>Kejuruan: <?php echo e($kejuruan->nama); ?> &nbsp;|&nbsp; MAK: <?php echo e($kelas->mak_uang_saku ?? '-'); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <p>Tarif: Rp 20.000/hari &nbsp;|&nbsp; Tanggal Cetak: <?php echo e($tanggal_cetak->format('d F Y, H:i')); ?></p>
    </div>

    <table style="border:none; margin-bottom:12px;">
        <tr>
            <td style="border:none; width:140px; font-weight:bold;">Periode Kelas</td>
            <td style="border:none;">: <?php echo e(\Carbon\Carbon::parse($kelas->tgl_mulai)->format('d/m/Y')); ?> – <?php echo e(\Carbon\Carbon::parse($kelas->tgl_selesai)->format('d/m/Y')); ?></td>
            <td style="border:none; width:140px; font-weight:bold;">Hari Efektif</td>
            <td style="border:none;">: <?php echo e(number_format($kelas->hari_efektif)); ?> hari</td>
        </tr>
        <tr>
            <td style="border:none; font-weight:bold;">Jumlah Terdata</td>
            <td style="border:none;">: <?php echo e($pembayaranList->count()); ?> orang</td>
            <td style="border:none; font-weight:bold;">Total Keseluruhan</td>
            <td style="border:none; font-weight:bold; color:#92400e;">: Rp <?php echo e(number_format($totalKeseluruhan, 0, ',', '.')); ?></td>
        </tr>
    </table>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pembayaranList->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:14%">No. Kuitansi</th>
                <th style="width:24%">Nama Peserta</th>
                <th style="width:14%">NIK</th>
                <th style="width:11%">No. HP</th>
                <th style="width:8%">Hari Hadir</th>
                <th style="width:9%">Tarif/Hari</th>
                <th style="width:8%">Tgl. Bayar</th>
                <th style="width:10%">Total (Rp)</th>
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
                <td><strong><?php echo e($item->hari_kehadiran ?? 0); ?></strong></td>
                <td>Rp 20.000</td>
                <td><?php echo e($item->tgl_spby->format('d/m/Y')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($item->total_uang, 0, ',', '.')); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>TOTAL:</strong></td>
                <td><strong><?php echo e($pembayaranList->sum('hari_kehadiran')); ?></strong></td>
                <td></td>
                <td></td>
                <td class="text-right"><strong>Rp <?php echo e(number_format($totalKeseluruhan, 0, ',', '.')); ?></strong></td>
            </tr>
        </tfoot>
    </table>
    <?php else: ?>
    <p style="text-align:center; padding: 20px; color: #b91c1c;">Belum ada data pembayaran uang saku untuk kelas ini.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <table style="border:none; margin-top:35px;">
        <tr>
            <td class="sign-cell">
                <p>Mengetahui,</p>
                <p>Kepala Pelatihan</p>
                <div class="sign-line"></div>
            </td>
            <td class="sign-cell"></td>
            <td class="sign-cell">
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
</html><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/pdf/uang-saku-kelas.blade.php ENDPATH**/ ?>