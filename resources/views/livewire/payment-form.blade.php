<div>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Form Pembayaran</h2>
        
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <form wire:submit.prevent="submitPayment">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Pilih Peserta</label>
                <select wire:model="peserta_id" class="w-full px-3 py-2 border rounded">
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($peserta_list as $peserta)
                        <option value="{{ $peserta->id }}">
                            {{ $peserta->nama }} 
                            @if(isset($peserta->kelas)) - {{ $peserta->kelas }} @endif
                            @if(isset($peserta->nis)) ({{ $peserta->nis }}) @endif
                        </option>
                    @endforeach
                </select>
                @error('peserta_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Jumlah Pembayaran (Rp)</label>
                <input type="number" wire:model="amount" class="w-full px-3 py-2 border rounded" placeholder="Masukkan jumlah">
                @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Metode Pembayaran</label>
                <select wire:model="payment_method" class="w-full px-3 py-2 border rounded">
                    <option value="transfer">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                    <option value="ewallet">E-Wallet</option>
                    <option value="cash">Tunai</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Catatan</label>
                <textarea wire:model="notes" rows="3" class="w-full px-3 py-2 border rounded" placeholder="Tambahkan catatan..."></textarea>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Bayar Sekarang
            </button>
        </form>
    </div>
</div>