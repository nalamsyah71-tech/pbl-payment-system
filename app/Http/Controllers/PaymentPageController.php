<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentPageController extends Controller
{
    public function create()
    {
        return view('payment-form');
    }
    
    public function store(Request $request)
    {
        // Sementara redirect ke success
        return redirect()->route('payment.success');
    }
    
    public function history()
    {
        return view('payment-history');
    }
}