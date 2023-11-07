<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $this->authorize('create','');
            $validator = $request->validated();
            $data = DB::table('users')->insert([
                   'first_name'=> $validator['first_name'],
                   'last_name'=> $validator['last_name'],
                   'username'=> $validator['username'],
                   'email'=> $validator['email'],
                   'password'=> Hash::make($validator['password']),
                   'created_at'=> now(),
                   'updated_at'=> now(),
                ]);

            if($data){
                Session::flash('success','User registration successfully');
                return redirect()->route('login-form');
            }else{
                Session::flash('error','Something went wrong!');
                return redirect()->route('register-form');
            }
        }catch (Exception $exception){
            return redirect()->route('register-form')->with('error',$exception->getMessage());
        }
    }

}
