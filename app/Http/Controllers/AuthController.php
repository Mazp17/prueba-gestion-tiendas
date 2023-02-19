<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function register() {
        return view('auth.register');
    }

    public function login(): View {
        return view('auth.login');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }

    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('pages.tiendas');
        }

        return redirect()->back();
    }

    public function save(Request $request) {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        auth()->login($user);

        return redirect()->intended('pages.tiendas');
    }



}
