<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function ShowLogin()
    {
        return view("Admin.Account.Login");
    }
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin');
        }
        else
        {
            return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không chính xác');
        }
    }
    public function Logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('showlogin');
    }
}
