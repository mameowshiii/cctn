<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markRead(Request $request)
    {
        if ($request->has('mark_all_admin')) {
            Notification::where('for_admin', true)->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }

        if ($request->has('notification_id')) {
            Notification::where('id', $request->notification_id)->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
