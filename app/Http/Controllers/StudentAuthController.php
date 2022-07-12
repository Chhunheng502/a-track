<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;

class StudentAuthController extends Controller
{
    public function loginForm()
    {
        return Inertia::render('Student/Login');
    }

    public function loginFormQr()
    {
        return Inertia::render('Student/LoginQr');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'max:50', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt($credentials)) {

            if (Cookie::has('link_route')) {
                $route = Cookie::get('link_route');
                Cookie::queue(Cookie::forget('link_route'));
                return redirect($route);
            }
    
            if (Cookie::has('qr_route')) {
                $route = Cookie::get('qr_route');
                Cookie::queue(Cookie::forget('qr_route'));
                return redirect($route);
            }
        }

        return redirect()->back();
    }
    
    public function registrationForm()
    {
        return Inertia::render('Student/Register');
    }

    public function register(Request $request)
    {
        $user = User::create(
            $request->validate([
                'name' => ['required', 'max:50'],
                'email' => ['required', 'max:50', 'email'],
                'password' => ['required', 'min:8', 'same:confirm_password'],
                'confirm_password' => ['required'],
            ])
        );

        $user->role = 'student';
        $user->save();

        return redirect()->route('student.login');
    }
}
