<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Peserta;  // Ganti Siswa menjadi Peserta
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentForm extends Component
{
    public $siswa_id = '';
    public $siswa_list = [];
    public $amount = '';
    public $payment_method = 'transfer';
    public $notes = '';

    protected $rules = [
        'siswa_id' => 'required|exists:peserta,id',  // Ganti siswa menjadi peserta
        'amount' => 'required|numeric|min:1000',
        'payment_method' => 'required',
    ];

    protected $messages = [
        'siswa_id.required' => 'Pilih siswa terlebih dahulu',
        'amount.required' => 'Jumlah pembayaran harus diisi',
        'amount.min' => 'Minimal pembayaran Rp 1.000',
    ];

    public function mount()
    {
        // Ganti Siswa menjadi Peserta
        $this->siswa_list = Peserta::orderBy('nama')->get();
    }

    public function submitPayment()
    {
        $this->validate();
        
        try {
            Payment::create([
                'invoice_number' => 'INV/' . date('Ymd') . '/' . Str::upper(Str::random(6)),
                'user_id' => Auth::id(),
                'siswa_id' => $this->siswa_id,
                'amount' => $this->amount,
                'paid_amount' => 0,
                'status' => 'pending',
                'payment_method' => $this->payment_method,
                'notes' => $this->notes,
                'expired_at' => now()->addHours(24),
            ]);
            
            session()->flash('success', 'Pembayaran berhasil!');
            return redirect()->route('payment.history');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
}