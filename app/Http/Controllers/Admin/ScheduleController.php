<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $slots = TimeSlot::orderBy('slot_time')->get();
        return view('admin.schedules.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $request->validate(['slot_time' => 'required']);

        $formattedTime = date('H:i:s', strtotime($request->slot_time));

        if (TimeSlot::where('slot_time', $formattedTime)->exists()) {
            return back()->withErrors(['slot_time' => 'That time slot (' . date('g:i A', strtotime($formattedTime)) . ') already exists.']);
        }

        TimeSlot::create(['slot_time' => $formattedTime, 'is_available' => true]);

        return redirect()->route('admin.schedules')
            ->with('success_message', 'New time slot added (' . date('g:i A', strtotime($formattedTime)) . ').');
    }

    public function toggleStatus(Request $request)
    {
        $slot = TimeSlot::findOrFail($request->slot_id);
        $slot->update(['is_available' => $request->new_status]);

        return redirect()->route('admin.schedules')->with('success_message', 'Time slot status updated.');
    }

    public function destroy(Request $request)
    {
        TimeSlot::findOrFail($request->slot_id)->delete();
        return redirect()->route('admin.schedules')->with('success_message', 'Time slot removed.');
    }
}
