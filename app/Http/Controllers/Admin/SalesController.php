<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['client', 'billing'])->orderBy('payment_date', 'desc')->get();
        $totalRevenue = $payments->sum('amount_paid');

        return view('admin.sales', compact('payments', 'totalRevenue'));
    }
}
