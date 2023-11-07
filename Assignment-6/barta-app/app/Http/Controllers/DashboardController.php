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

            $auth_user = Auth::user();
            $posts = DB::table('posts')->select(
                'users.id',
                        'users.first_name',
                        'users.last_name',
                        'users.username',
                        'users.email',
                        'posts.id',
                        'posts.description',
                        'posts.created_at',
                        'posts.updated_at')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->get();
            return view('dashboard',['posts'=>$posts,'auth_user'=>$auth_user]);
        }
        return redirect()->route('login-form')->with('error','You have login first');
    }
}
