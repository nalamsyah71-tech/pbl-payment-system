<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pembayaran</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f0f0f0; }
        .success { color: green; font-weight: bold; }
        a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Riwayat Pembayaran</h2>
        
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->invoice_number }}</td>
                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="success">{{ $payment->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center">Belum ada pembayaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <br>
        <a href="/payment/create">← Kembali ke Form</a>
    </div>
</body>
</html>