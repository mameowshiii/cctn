<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with('client')->orderBy('created_at', 'desc')->get();
        return view('admin.maintenance.index', compact('requests'));
    }

    public function update(Request $request)
    {
        $maintenance = MaintenanceRequest::findOrFail($request->request_id);
        $maintenance->update([
            'status'         => $request->status,
            'follow_up_note' => $request->follow_up_note ?? '',
        ]);

        return redirect()->route('admin.maintenance')->with('success_message', 'Maintenance request updated.');
    }
}
