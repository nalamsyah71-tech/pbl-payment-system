<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Peserta;  // Ganti Siswa jadi Peserta
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create()
    {
        $peserta_list = Peserta::all();  // Ganti Siswa jadi Peserta
        return view('payment-form', compact('peserta_list'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required',  // Ganti siswa_id jadi peserta_id
            'amount' => 'required|numeric|min:1000',
        ]);

        Payment::create([
            'invoice_number' => 'INV/' . date('Ymd') . '/' . Str::random(6),
            'user_id' => 1,
            'peserta_id' => $request->peserta_id,  // Ganti siswa_id jadi peserta_id
            'amount' => $request->amount,
            'paid_amount' => 0,
            'status' => 'success',
            'payment_method' => $request->payment_method ?? 'cash',
            'expired_at' => now()->addHours(24),
        ]);

        return redirect('/payment/history')->with('success', 'Pembayaran berhasil!');
    }
    
    public function history()
    {
        $payments = Payment::orderBy('created_at', 'desc')->paginate(10);
        return view('payment-history', compact('payments'));
    }
}