<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Asuransi BPJS - {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11px; margin: 15px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #1e3a5f; padding-bottom: 10px; }
        .header h1 { font-size: 15px; margin: 0 0 4px; color: #1e3a5f; }
        .header p { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #aaa; padding: 5px 7px; }
        th { background-color: #166534; color: white; font-weight: bold; text-align: center; font-size: 10px; }
        td { text-align: center; }
        td.text-left { text-align: left; }
        td.text-right { text-align: right; }
        tr:nth-child(even) { background-color: #f0fdf4; }
        tfoot tr td { background-color: #dcfce7; font-weight: bold; }
        .sign-cell { width: 33%; text-align: center; vertical-align: top; border: none !important; }
        .sign-line { margin-top: 50px; border-top: 1px solid #333; width: 80%; margin-left: auto; margin-right: auto; }
        .footer { margin-top: 15px; text-align: center; font-size: 9px; color: #888; border-top: 1px solid #ddd; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAFTAR PESERTA ASURANSI BPJS KETENAGAKERJAAN</h1>
        <p>{{ $kelas->pelatihan->nama ?? '-' }} &nbsp;|&nbsp; Kelas: <strong>{{ $kelas->nama_kelas }}</strong></p>
        @if($kejuruan)
        <p>Kejuruan: {{ $kejuruan->nama }} &nbsp;|&nbsp; MAK: {{ $kelas->mak_asuransi ?? '-' }}</p>
        @endif
        <p>Tanggal Cetak: {{ $tanggal_cetak->format('d F Y, H:i') }}</p>
    </div>

    <table style="border:none; margin-bottom:12px;">
        <tr>
            <td style="border:none; width:140px; font-weight:bold;">Periode Kelas</td>
            <td style="border:none;">: {{ \Carbon\Carbon::parse($kelas->tgl_mulai)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($kelas->tgl_selesai)->format('d/m/Y') }}</td>
            <td style="border:none; width:140px; font-weight:bold;">Jumlah Terdata</td>
            <td style="border:none;">: {{ $pembayaranList->count() }} orang</td>
        </tr>
        <tr>
            <td style="border:none; font-weight:bold;">Total Premi</td>
            <td style="border:none; font-weight:bold; color:#166534;" colspan="3">: Rp {{ number_format($totalPremi, 0, ',', '.') }}</td>
        </tr>
    </table>

    @if($pembayaranList->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:14%">No. Kuitansi</th>
                <th style="width:12%">No. SK</th>
                <th style="width:26%">Nama Peserta</th>
                <th style="width:15%">NIK</th>
                <th style="width:13%">No. HP</th>
                <th style="width:9%">Tgl. Bayar</th>
                <th style="width:10%">Premi (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaranList as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->no_kuitansi }}</td>
                <td>{{ $item->no_sk ?? '-' }}</td>
                <td class="text-left">{{ $item->peserta?->nama ?? '-' }}</td>
                <td>{{ $item->peserta?->nik ?? '-' }}</td>
                <td>{{ $item->peserta?->no_hp ?? '-' }}</td>
                <td>{{ $item->tgl_spby->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($item->total_premi, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-right"><strong>TOTAL PREMI:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPremi, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
    @else
    <p style="text-align:center; padding: 20px; color: #b91c1c;">Belum ada data pembayaran asuransi untuk kelas ini.</p>
    @endif

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
        Dokumen ini dicetak secara otomatis dari Sistem Pembayaran &mdash; {{ $tanggal_cetak->format('d/m/Y H:i') }}
    </div>
</body>
</html>