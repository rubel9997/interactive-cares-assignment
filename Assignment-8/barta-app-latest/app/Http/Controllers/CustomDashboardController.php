<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomDashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {

            $auth_user = Auth::user();
            $posts = DB::table('posts')->select('users.*', 'posts.*', 'posts.created_at as post_created_at')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->orderBy('posts.created_at', 'desc')
//                ->limit(20)
                ->get();

            return view('dashboard', ['posts' => $posts, 'auth_user' => $auth_user]);
        }

        return redirect()->route('login')->with('error', 'You have login first');
    }
}
