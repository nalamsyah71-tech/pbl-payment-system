<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>SPPBy Pulsa {{ $pembayaranPulsa->no_kuitansi }}</title><style>body{font-family: sans-serif; font-size: 12px;} table{width:100%; border-collapse: collapse;} th,td{border:1px solid #ddd; padding:8px; text-align:left;} .header{text-align:center; margin-bottom:20px;} .total{font-weight:bold;}</style></head>
<body>
<div class="header"><h2>SPPBy Bantuan Pulsa Internet</h2><p>No. Kuitansi: {{ $pembayaranPulsa->no_kuitansi }} | Tanggal: {{ $pembayaranPulsa->tgl_spby->format('d/m/Y') }}</p></div>
<div><p><strong>Kelas:</strong> {{ $pembayaranPulsa->kelas->nama_kelas }}<br><strong>Pelatihan:</strong> {{ $pembayaranPulsa->kelas->pelatihan->nama }}<br><strong>Kejuruan:</strong> {{ $pembayaranPulsa->kelas->pelatihan->kejuruan->nama }}</p></div>
<table><thead><tr><th>No</th><th>Nama Peserta</th><th>No HP</th><th>Nominal (Rp)</th></tr></thead>
<tbody>@foreach($pembayaranPulsa->detail_peserta ?? [] as $idx => $p)<tr><td>{{ $idx+1 }}</td><td>{{ $p['nama'] }}</td><td>{{ $p['no_hp'] }}</td><td>{{ number_format($p['nominal'], 0, ',', '.') }}</td></tr>@endforeach</tbody>
</table>
<div style="margin-top:20px; text-align:right;"><strong>Total: Rp {{ number_format($pembayaranPulsa->total_uang, 0, ',', '.') }}</strong></div>
</body>
</html>