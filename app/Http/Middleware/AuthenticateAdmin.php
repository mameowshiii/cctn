<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            session()->flash('redirect_message', 'Please log in as an administrator to access the admin dashboard.');
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
