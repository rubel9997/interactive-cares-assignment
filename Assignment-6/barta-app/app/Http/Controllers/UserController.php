<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function profile()
    {
        $data = DB::table('users')->where('id',Auth::id())->first();
        return view('user.profile',['data'=>$data]);
    }

    public function edit(Request $request)
    {
        $data = DB::table('users')->where('id',Auth::id())->first();
        return view('user.edit',['data'=>$data]);
    }

    public function update(Request $request)
    {
        $fullName = $request->first_name.' '.$request->last_name;

        $data = DB::table('users')->update([
            'name'=>$fullName,
        ]);
    }
}
