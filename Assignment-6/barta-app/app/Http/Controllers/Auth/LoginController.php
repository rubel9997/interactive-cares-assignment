<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
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

    public function login(LoginUserRequest $request)
    {
        try{
            $credentials = $request->safe()->only(['email', 'password']);
            if(Auth::attempt($credentials)){
                return redirect()->intended('dashboard')->with('success','You have Successfully Login');
            }else{
                return back()->withErrors(['email' => 'The provided credentials do not match our records.',])->onlyInput('email');
            }

        }catch (\Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
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
