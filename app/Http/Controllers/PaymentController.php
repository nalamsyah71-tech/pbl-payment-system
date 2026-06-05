<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create()
    {
        $peserta_list = Peserta::orderBy('nama')->get();
        return view('payment-form', compact('peserta_list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_id'     => 'required|exists:pesertas,id',
            'amount'         => 'required|numeric|min:1000',
            'payment_method' => 'nullable|string|in:cash,transfer,midtrans',
        ]);

        Payment::create([
            'invoice_number' => 'INV/' . date('Ymd') . '/' . Str::upper(Str::random(6)),
            'user_id'        => auth()->id(),
            'peserta_id'     => $request->peserta_id,
            'amount'         => $request->amount,
            'paid_amount'    => 0,
            'status'         => 'pending',
            'payment_method' => $request->payment_method ?? 'cash',
            'expired_at'     => now()->addHours(24),
        ]);

        return redirect('/payment/history')->with('success', 'Pembayaran berhasil dibuat, menunggu konfirmasi.');
    }

    public function history()
    {
        $payments = Payment::with('peserta')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('payment-history', compact('payments'));
    }
}
