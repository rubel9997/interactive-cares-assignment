<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'password' => 'nullable|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user_data = [
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'bio'=>$request->bio,
            ];

            if ($request->has('password') && !empty($request->input('password'))) {
                $data['password'] = Hash::make($request->input('password'));
            }


            $data = DB::table('users')->where('id',Auth::id())->update($user_data);

            if($data){
                Session::flash('success','Your profile updated successfully');
                return redirect()->route('profile');
            }else{
                return redirect()->route('profile');
            }

        }catch (Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }
}
