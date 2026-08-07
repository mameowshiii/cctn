<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();

        $notifications = Notification::where('for_admin', false)
            ->where(function ($q) use ($client) {
                $q->where('client_id', $client->id)
                  ->orWhereNull('client_id');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        $client = Auth::guard('client')->user();
        $notification = Notification::where('id', $id)
            ->where('for_admin', false)
            ->where(function ($q) use ($client) {
                $q->where('client_id', $client->id)
                  ->orWhereNull('client_id');
            })
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return back()->with('success_message', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        $client = Auth::guard('client')->user();

        Notification::where('for_admin', false)
            ->where(function ($q) use ($client) {
                $q->where('client_id', $client->id)
                  ->orWhereNull('client_id');
            })
            ->update(['is_read' => true]);

        return back()->with('success_message', 'All notifications marked as read.');
    }
}
