<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BillingResource;
use App\Models\BillingAccount;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    // ─── GET /api/v1/billing ─────────────────────────────────────────────────
    public function index(Request $request)
    {
        $client = $request->user();

        $statements = BillingAccount::where('client_id', $client->id)
            ->orderBy('due_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $balance = $statements->where('status', '!=', 'paid')->sum('total_amount_due');

        return response()->json([
            'success'    => true,
            'balance'    => (float) $balance,
            'statements' => BillingResource::collection($statements),
        ]);
    }
}
