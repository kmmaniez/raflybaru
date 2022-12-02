<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('login.index',[
            'title_page' => 'Login Page'
        ]);
    }

    public function authenticate(Request $request)
    {
        // dd($request->toArray());
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        // jika sukses
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('login-error','Login failed');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
