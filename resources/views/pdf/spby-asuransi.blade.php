<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SPPBy Asuransi - {{ $pembayaranAsuransi->no_kuitansi }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { font-size: 18px; margin: 0; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 5px; }
        .info-table td:first-child { width: 120px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .signature { margin-top: 50px; display: flex; justify-content: space-between; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SPPBy (Surat Pertanggungjawaban Belanja)</h1>
        <p>Pembayaran Asuransi BPJS</p>
        <p>No. Kuitansi: {{ $pembayaranAsuransi->no_kuitansi }}</p>
    </div>

    @php
        $kelas = $pembayaranAsuransi->kelas;
        $detailPeserta = $pembayaranAsuransi->detail_peserta;
        if (is_string($detailPeserta)) {
            $detailPeserta = json_decode($detailPeserta, true);
        }
        if (!is_array($detailPeserta)) {
            $detailPeserta = [];
        }
    @endphp

    <table class="info-table">
        <tr><td>Tanggal SPBY:</td><td>{{ \Carbon\Carbon::parse($pembayaranAsuransi->tgl_spby)->format('d/m/Y') }}</td></tr>
        <tr><td>Kelas:</td><td>{{ $kelas->nama_kelas ?? '-' }}</td></tr>
        <tr><td>Total Pembayaran:</td><td class="text-right"><strong>Rp {{ number_format($pembayaranAsuransi->total_premi, 0, ',', '.') }}</strong></td></tr>
    </table>

    <h3>Data Peserta</h3>
    <table>
        <thead><tr><th>No</th><th>Nama Peserta</th><th>No. HP</th><th>Nominal (Rp)</th></tr></thead>
        <tbody>
            @forelse($detailPeserta as $index => $peserta)
            <tr><td>{{ $index + 1 }}</td><td>{{ $peserta['nama'] ?? '-' }}</td><td>{{ $peserta['no_hp'] ?? '-' }}</td><td class="text-right">Rp {{ number_format($peserta['nominal'] ?? 0, 0, ',', '.') }}</td></tr>
            @empty
            <tr><td colspan="4" style="text-align: center">Tidak ada data peserta</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature">
        <div><p>Mengetahui,</p><p>Kepala Pelatihan</p><br><br><br><p>(_________________)</p></div>
        <div><p>Dibuat oleh,</p><p>Bendahara</p><br><br><br><p>(_________________)</p></div>
    </div>
</body>
</html>