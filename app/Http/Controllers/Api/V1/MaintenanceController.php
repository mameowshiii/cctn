<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaintenanceResource;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    // ─── GET /api/v1/maintenance ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $client = $request->user();

        $requests = MaintenanceRequest::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success'  => true,
            'requests' => MaintenanceResource::collection($requests),
        ]);
    }

    // ─── POST /api/v1/maintenance ────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'subject'     => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'priority'    => 'required|in:low,medium,high',
        ]);

        $client = $request->user();

        $maintenance = MaintenanceRequest::create([
            'client_id'   => $client->id,
            'subject'     => $request->subject,
            'description' => $request->description,
            'priority'    => $request->priority,
            'status'      => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Maintenance request submitted successfully.',
            'request' => new MaintenanceResource($maintenance),
        ], 201);
    }
}
