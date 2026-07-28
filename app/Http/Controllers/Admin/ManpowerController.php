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
            'name' => 'required|string|max:150',
            'role' => 'required|string|max:100',
        ]);

        Manpower::create($request->only(['name', 'role', 'availability', 'notes']));

        return redirect()->route('admin.manpower')->with('success_message', 'Staff member added.');
    }

    public function updateStatus(Request $request)
    {
        $crew = Manpower::findOrFail($request->crew_id);
        $crew->update(['availability' => $request->availability]);

        return redirect()->route('admin.manpower')->with('success_message', 'Status updated.');
    }
}
