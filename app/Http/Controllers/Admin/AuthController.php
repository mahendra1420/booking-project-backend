<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = AdminUser::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        if (! $admin->status) {
            return back()->withErrors(['email' => 'Your account is suspended.']);
        }

        Auth::guard('admin')->login($admin, $request->boolean('remember'));

        $admin->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        AuditLog::log('login', 'auth', $admin->id, null, null, "Admin logged in from {$request->ip()}");

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        AuditLog::log('logout', 'auth', Auth::guard('admin')->id());
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
