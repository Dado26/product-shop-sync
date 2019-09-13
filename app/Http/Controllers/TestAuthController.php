<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class TestAuthController extends Controller
{
    public function LoginForm()
    {
        return view('test.login');
    }

    public function LoginAttempt(LoginRequest $request)
    {
        $email    = $request->get('email');
        $password = $request->get('password');
        $remember = $request->get('remember_me');

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->route('test.product_auth');
        }

        return redirect()->back()->withErrors(['Wrong email or password']);
    }

    public function LogOut()
    {
        Auth::logout();

        return redirect()->route('login.form');
    }
}
