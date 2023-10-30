<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            return redirect()->intended('dashboard')->with('success','You have Successfully Login');
        }else{
            return back()->withErrors(['email' => 'The provided credentials do not match our records.',])->onlyInput('email');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        Session::flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
