<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function LoginForm()
    {
        return view('auth.login');
    }

    public function LoginAttempt(LoginRequest $request)
    {
        $email    = $request->get('email');
        $password = $request->get('password');
        $remember = $request->get('remember_me');
<<<<<<< HEAD
        
        if(Auth::attempt(['email'=>$email, 'password'=>$password], $remember)){
            return redirect()->route('index.users');
=======

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->route('home');
>>>>>>> b67ec6197937b166c1868ca2bbb3b6cba525ab4a
        }
        return redirect()->back()->withErrors(['Wrong email or password']);
    }

    public function LogOut(){
        Auth::logout();
        
        return redirect()->route('login.form');
    }
}
