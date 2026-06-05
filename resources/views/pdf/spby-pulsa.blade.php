<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SPPBy Pulsa - {{ $pembayaranPulsa->no_kuitansi }}</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>SPPBy (Surat Pertanggungjawaban Belanja)</h1>
        <p>Pembayaran Pulsa Internet</p>
        <p>No. Kuitansi: {{ $pembayaranPulsa->no_kuitansi }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td>Tanggal SPBY:</td>
            <td>{{ \Carbon\Carbon::parse($pembayaranPulsa->tgl_spby)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kelas:</td>
            <td>{{ $pembayaranPulsa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pelatihan:</td>
            <td>{{ $pembayaranPulsa->kelas->pelatihan->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kejuruan:</td>
            <td>{{ $pembayaranPulsa->kelas->pelatihan->kejuruan->nama ?? '-' }}</td>
        </tr>
    </table>

    <h3>Data Penerima Pulsa</h3>
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
            <tr>
                <td>1</td>
                <td>{{ $pembayaranPulsa->peserta->nama ?? '-' }}</td>
                <td>{{ $pembayaranPulsa->peserta->no_hp ?? '-' }}</td>
                <td style="text-align: right">Rp {{ number_format($pembayaranPulsa->total_uang, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Total Pembayaran: <strong>Rp {{ number_format($pembayaranPulsa->total_uang, 0, ',', '.') }}</strong></p>
    </div>

    <div class="signature">
        <div>
            <p>Mengetahui,</p>
            <p>Kepala Pelatihan</p>
            <br><br>
            <p>(_________________)</p>
        </div>
        <div>
            <p>Dibuat oleh,</p>
            <p>Bendahara</p>
            <br><br>
            <p>(_________________)</p>
        </div>
    </div>
</body>
</html>