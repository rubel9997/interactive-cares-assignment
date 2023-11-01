<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $validator = $request->validated();

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user_data = $request->safe()->only(['first_name','last_name','username','email','password']);
            $data = $this->create($user_data);

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

    public function create(array $data)
    {
        return DB::table('users')->insert([
           'first_name'=>$data['first_name'],
           'last_name'=>$data['last_name'],
           'username'=>$data['username'],
           'email'=>$data['email'],
           'password'=>Hash::make($data['password']),
        ]);
    }
}
