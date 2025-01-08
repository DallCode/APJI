<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.loginForm');
    }

    // Proses login
    public function authenticate(Request $request)
    {
        // Validasi input
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validated->fails()) {
            return redirect()->route('login')
                ->withErrors($validated)
                ->withInput();
        }

        // Proses otentikasi
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Cek apakah user aktif
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
            }

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'anggota') {
                return redirect()->route('dashboard');
            }
        }

        return redirect()->route('login')->with('error', 'Email atau password salah.');
    }

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         if ($user->role === 'admin') {
    //             return redirect()->route('admin.dashboard');
    //         } elseif ($user->role === 'anggota') {
    //             return redirect()->route('dashboard');
    //         } else {
    //             return redirect()->route('landingPage');
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Email atau Password salah.');
    // }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('landingPage');
    }
}
