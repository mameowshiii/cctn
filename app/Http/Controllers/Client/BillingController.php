<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BillingAccount;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $statements = BillingAccount::where('client_id', $client->id)
            ->orderBy('due_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $balance = $statements->where('status', '!=', 'paid')->sum('total_amount_due');

        return view('client.billing', compact('client', 'statements', 'balance'));
    }
}
