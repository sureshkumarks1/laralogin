<?php

namespace App\Http\Controllers;

use App\Mail\UserCreatedMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        // return view('welcome');
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }
    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        // dd($request->all());
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

       Mail::to($request->email)->send(new UserCreatedMail() );

        return redirect('/login')->with('success', 'Account created!');
    }

    // Handle login
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            if (auth()->user()->role == 'admin') {
                return redirect('/admin');
            }

            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid login details');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
