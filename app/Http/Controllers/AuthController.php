<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function LoginForm()
    {
$user = Auth::user();
return view('auth.login', compact('user'));
    }
    
    public function LoginAttempt(LoginRequest $request) 
            {
        $email = $request->get('email');
        $password = $request->get('password');
        $remember = $request->get('remember_me');
        
        if(Auth::attempt(['email'=>$email, 'password'=>$password], $remember)){
            return redirect()->route('index.users');
        }
        return redirect()->back()->withErrors(['Wrong email or password']);
    }

    public function LogOut(){
        Auth::logout();
        
        return redirect()->route('login.form');
    }
}
