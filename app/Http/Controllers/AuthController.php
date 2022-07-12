<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function loginForm()
    {
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'max:50', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('admin/classes');
        }

        return redirect()->back()->withErrors([
            'message' => 'Incorrect Credentials'
        ]);
    }
    
    public function registrationForm()
    {
        return Inertia::render('Admin/Auth/Register');
    }

    public function register(Request $request)
    {
        User::create(
            $request->validate([
                'name' => ['required', 'max:50'],
                'email' => ['required', 'max:50', 'email'],
                'password' => ['required', 'min:8', 'same:confirm_password'],
                'confirm_password' => ['required'],
            ])
        );

        return redirect('admin/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }
}
