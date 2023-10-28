<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect()->route('login-form')->with('error','Opps! You do not have access');
    }
}
