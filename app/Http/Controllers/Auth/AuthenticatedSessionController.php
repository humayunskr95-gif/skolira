<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show login page
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 🔒 Safety check
        if (!$user || !$user->role) {
            return redirect('/dashboard');
        }

        // 🔥 DOMAIN SAFE REDIRECT
        return match ($user->role) {

            'super_admin'   => redirect('/super-admin/dashboard'),
            'school_admin'  => redirect('/school-admin/dashboard'),
            'teacher'       => redirect('/teacher/dashboard'),
            'student'       => redirect('/student/dashboard'),
            'parent'        => redirect('/parent/dashboard'),
            'accountant'    => redirect('/accountant/dashboard'),
            'driver'        => redirect('/driver/dashboard'),
            'hostel_super'  => redirect('/hostel/dashboard'),

            default         => redirect('/dashboard'),
        };
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔥 SAFE REDIRECT
        return redirect('/');
    }
}