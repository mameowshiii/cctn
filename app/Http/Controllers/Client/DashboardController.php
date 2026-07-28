<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\BillingAccount;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();

        // Fetch stats
        $totalAppointments  = Appointment::where('client_id', $client->id)->count();
        $pendingAppointments = Appointment::where('client_id', $client->id)->where('status', 'pending')->count();
        $approvedAppointments = Appointment::where('client_id', $client->id)->where('status', 'approved')->count();

        // Recent appointments
        $recentAppointments = Appointment::with('service')
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('client.dashboard', compact(
            'client', 'totalAppointments', 'pendingAppointments',
            'approvedAppointments', 'recentAppointments'
        ));
    }

    public function updateProfile(Request $request)
    {
        $client = Auth::guard('client')->user();

        $request->validate([
            'firstname'   => 'required|string|max:50',
            'lastname'    => 'required|string|max:50',
            'email'       => 'required|email|max:100|unique:clients,email,' . $client->id,
            'username'    => 'required|string|max:50|unique:clients,username,' . $client->id,
            'contact_no'  => 'required|string|max:20',
            'birthdate'   => 'required|date',
        ]);

        $data = $request->only([
            'firstname', 'middlename', 'lastname', 'email', 'username',
            'contact_no', 'civil_status', 'address_barangay', 'address_municipality',
            'address_province', 'gender', 'birthdate', 'place_of_birth',
        ]);

        // Calculate age
        if (!empty($data['birthdate'])) {
            $data['age'] = \Carbon\Carbon::parse($data['birthdate'])->age;
        }

        // Handle new password
        if ($request->filled('new_password')) {
            $request->validate(['new_password' => 'min:8']);
            $data['password'] = Hash::make($request->new_password);
        }

        // Handle photo upload
        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            $file = $request->file('profile_photo');
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($file->getClientOriginalExtension()), $allowed) && $file->getSize() < 5000000) {
                $filename = 'avatar_' . uniqid('', true) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $data['profile_photo'] = 'uploads/' . $filename;
            }
        }

        $client->update($data);

        return redirect()->route('client.dashboard')->with('success_message', 'Profile updated successfully!');
    }
}
