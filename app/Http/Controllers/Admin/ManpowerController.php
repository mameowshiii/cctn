<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manpower;
use Illuminate\Http\Request;

class ManpowerController extends Controller
{
    public function index()
    {
        $staff = Manpower::orderBy('name')->get();
        return view('admin.manpower.index', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:150',
            'role'         => 'required|string|max:100',
            'availability' => 'nullable|string|in:Available,Busy,Off Duty',
            'notes'        => 'nullable|string|max:500',
        ]);

        Manpower::create([
            'name'         => $request->name,
            'role'         => $request->role,
            'availability' => $request->input('availability', 'Available') ?: 'Available',
            'notes'        => $request->notes,
        ]);

        return redirect()->route('admin.manpower')->with('success_message', 'Staff member added.');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'crew_id'      => 'required|exists:manpower,id',
            'availability' => 'required|string|in:Available,Busy,Off Duty',
        ]);

        $crew = Manpower::findOrFail($request->crew_id);
        $crew->update(['availability' => $request->availability]);

        return redirect()->route('admin.manpower')->with('success_message', 'Status updated.');
    }
}
