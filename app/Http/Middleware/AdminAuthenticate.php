<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('admin.login');
        }

        if (! Auth::guard('admin')->user()->status) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'Your account has been suspended.']);
        }

        return $next($request);
    }
}
