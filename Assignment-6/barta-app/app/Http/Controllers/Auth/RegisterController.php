<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ], [
                'name.required' => 'The name field is required.',
                'username.required' => 'The username field is required.',
                'username.unique' => 'The username has already been taken.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'The email address has already been taken.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least :min characters.',
            ], [
                'name' => 'Full Name',
                'username' => 'Username',
                'email' => 'Email Address',
                'password' => 'Password',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->create($request->all());

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
           'name'=>$data['name'],
           'username'=>$data['username'],
           'email'=>$data['email'],
           'password'=>Hash::make($data['password']),
        ]);
    }
}
