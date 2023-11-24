<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomDashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {

            $posts = Post::with(['user', 'comments', 'viewCounts', 'reactCounts'])->latest()->get();

            return view('dashboard', ['posts' => $posts]);
        }

        return redirect()->route('login')->with('error', 'You have login first');
    }

    public function search(Request $request)
    {
        $data = User::with('posts')->whereHas('posts', function ($query) use ($request) {
            $query->where('description', 'like', '%'.$request->search.'%');
        })
            ->orWhere(function ($query) use ($request) {
                $query->where('first_name', 'like', '%'.$request->search.'%')
                    ->orWhere('last_name', 'like', '%'.$request->search.'%')
                    ->orWhere('username', 'like', '%'.$request->search.'%');
            })
            ->get();

        return view('user.search', ['data' => $data]);
    }
}
