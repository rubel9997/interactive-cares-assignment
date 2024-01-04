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

         //   $posts = Post::with(['user', 'comments', 'viewCounts', 'reactCounts'])->latest()->get();

            return view('dashboard');
        }

        return redirect()->route('login')->with('error', 'You have login first');
    }

    public function search(Request $request)
    {
        $data = User::where(function ($query) use ($request) {
            $query->where('first_name', 'like', '%'.$request->search.'%')
                ->orWhere('last_name', 'like', '%'.$request->search.'%')
                ->orWhere('username', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%');
        })->get();

        return view('user.search', ['data' => $data,'search' => $request->search]);
    }

    public function allNotification()
    {
        $notifications = auth()->user()->notifications()->get();

        auth()->user()->unreadNotifications()->update(['read_at'=>now()]);

       return view('notifications.index',['notifications'=>$notifications]);

    }
}
