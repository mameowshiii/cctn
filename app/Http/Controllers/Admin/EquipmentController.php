<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::orderBy('name')->get();
        return view('admin.equipment.index', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'category' => 'required|string|max:100',
        ]);

        Equipment::create($request->only(['name', 'category', 'quantity', 'status', 'notes']));

        return redirect()->route('admin.equipment')->with('success_message', 'Equipment item added.');
    }
}
