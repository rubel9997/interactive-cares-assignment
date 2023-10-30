<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if(Auth::check()){
            $data = DB::table('users')->where('id',Auth::id())->first();
            return view('dashboard',['data'=>$data]);
        }
        return redirect()->route('login-form')->with('error','You have login first');
    }
}
