<!DOCTYPE html>
<html>
<head>
    <title>Form Pembayaran</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        input, select, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #28a745; color: white; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Pembayaran</h2>
        
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        <form method="POST" action="/payment/store">
            @csrf
            <div>
                <label>Pilih Peserta</label>
                <select name="peserta_id" required>
                    <option value="">-- Pilih --</option>
                    @foreach($peserta_list as $peserta)
                        <option value="{{ $peserta->id }}">{{ $peserta->nama }} - {{ $peserta->kelas }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label>Jumlah Pembayaran (Rp)</label>
                <input type="number" name="amount" required min="1000">
            </div>
            
            <div>
                <label>Metode</label>
                <select name="payment_method">
                    <option value="cash">Tunai</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>
            
            <button type="submit">Bayar Sekarang</button>
        </form>
        
        <br>
        <a href="/payment/history">Lihat Riwayat</a>
    </div>
</body>
</html>