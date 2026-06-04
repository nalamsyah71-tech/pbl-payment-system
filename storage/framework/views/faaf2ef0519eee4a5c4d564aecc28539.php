<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SPPBy Uang Saku - <?php echo e($pembayaranUangSaku->no_kuitansi); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px;
            border: none;
        }
        .info-table td:first-child {
            width: 120px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SPPBy (Surat Pertanggungjawaban Belanja)</h1>
        <p>Pembayaran Uang Saku</p>
        <p>No. Kuitansi: <?php echo e($pembayaranUangSaku->no_kuitansi); ?></p>
    </div>

    <?php
        $kelas = $pembayaranUangSaku->kelas;
        $pelatihan = $kelas->pelatihan ?? null;
        $kejuruan = $pelatihan->kejuruan ?? null;
        $detailPeserta = $pembayaranUangSaku->detail_peserta;
        
        if (is_string($detailPeserta)) {
            $detailPeserta = json_decode($detailPeserta, true);
        }
        if (!is_array($detailPeserta)) {
            $detailPeserta = [];
        }
    ?>

    <table class="info-table">
        <tr>
            <td>Tanggal SPBY:</td>
            <td><?php echo e(\Carbon\Carbon::parse($pembayaranUangSaku->tgl_spby)->format('d/m/Y')); ?></td>
        </tr>
        <tr>
            <td>Kelas:</td>
            <td><?php echo e($kelas->nama_kelas ?? '-'); ?></td>
        </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pelatihan): ?>
        <tr>
            <td>Pelatihan:</td>
            <td><?php echo e($pelatihan->nama ?? '-'); ?></td>
        </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kejuruan): ?>
        <tr>
            <td>Kejuruan:</td>
            <td><?php echo e($kejuruan->nama ?? '-'); ?></td>
        </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <tr>
            <td>Total Pembayaran:</td>
            <td class="text-right"><strong>Rp <?php echo e(number_format($pembayaranUangSaku->total_uang, 0, ',', '.')); ?></strong></td>
        </tr>
    </table>

    <h3>Data Penerima Uang Saku</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>No. HP</th>
                <th>Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $detailPeserta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $peserta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($peserta['nama'] ?? '-'); ?></td>
                <td><?php echo e($peserta['no_hp'] ?? '-'); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($peserta['nominal'] ?? 0, 0, ',', '.')); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="4" style="text-align: center">Tidak ada data peserta</td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <div class="signature">
        <div>
            <p>Mengetahui,</p>
            <p>Kepala Pelatihan</p>
            <br><br><br>
            <p>(_________________)</p>
        </div>
        <div>
            <p>Dibuat oleh,</p>
            <p>Bendahara</p>
            <br><br><br>
            <p>(_________________)</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\USER\pbl-payment-system\resources\views/pdf/spby-uang-saku.blade.php ENDPATH**/ ?>