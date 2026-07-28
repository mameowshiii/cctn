<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $filterStatus  = $request->get('status', 'all');
        $filterService = $request->get('service_id', 0);
        $filterDate    = $request->get('date', '');

        $query = Appointment::with(['client', 'service']);

        if ($filterStatus !== 'all') {
            $query->where('status', $filterStatus);
        }
        if ($filterService > 0) {
            $query->where('service_id', $filterService);
        }
        if (!empty($filterDate)) {
            $query->where('preferred_date', $filterDate);
        }

        $appointments = $query->orderBy('preferred_date', 'desc')
            ->orderBy('preferred_time', 'desc')
            ->get();

        $services = Service::orderBy('service_name')->get();

        // If manage_id is set, fetch that appointment for the edit modal
        $manageAppointment = null;
        $manageId = $request->get('manage_id', 0);
        if ($manageId > 0) {
            $manageAppointment = Appointment::with(['client', 'service'])->find($manageId);
        }

        return view('admin.appointments.index', compact(
            'appointments', 'services', 'filterStatus', 'filterService',
            'filterDate', 'manageAppointment'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'preferred_date' => 'required|date',
            'preferred_time' => 'required',
            'status'         => 'required|in:pending,approved,cancelled',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        // Check conflict (unless cancelling)
        if ($request->status !== 'cancelled') {
            if (Appointment::hasConflict($request->preferred_date, $request->preferred_time, $appointment->id)) {
                return back()->withErrors(['preferred_time' => 'Scheduling Conflict: That slot is already booked.'])->withInput();
            }
        }

        $appointment->update([
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'status'         => $request->status,
            'admin_notes'    => $request->input('admin_notes', ''),
        ]);

        return redirect()->route('admin.appointments')
            ->with('success_message', "Appointment #{$appointment->id} updated successfully.");
    }

    public function quickUpdate(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'status'         => 'required|in:approved,cancelled',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->update([
            'status'      => $request->status,
            'admin_notes' => $request->input('admin_notes', ''),
        ]);

        return redirect()->route('admin.appointments')
            ->with('success_message', "Appointment #{$appointment->id} status set to {$request->status}.");
    }
}
