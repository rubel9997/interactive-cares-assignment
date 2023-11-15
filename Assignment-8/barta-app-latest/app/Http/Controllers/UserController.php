<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = DB::table('users')->where('username',$request->username)->first();

        $posts = DB::table('posts')->select('users.*','posts.*','posts.created_at as post_created_at')
                    ->join('users','posts.user_id','=','users.id')
                    ->where('user_id',$user->id)
                    ->orderBy('posts.created_at',"desc")
                    ->get();

        return view('user.profile',['posts'=>$posts,'user'=>$user]);
    }

    public function edit(Request $request)
    {
        $data = DB::table('users')->where('id',Auth::id())->first();
        return view('user.edit',['data'=>$data]);
    }

    public function update(UserUpdateRequest $request)
    {
        try{
            $validator = $request->validated();
            $auth_user = Auth::user();
            $user_data = [
                'first_name'=> $validator['first_name'],
                'last_name'=> $validator['last_name'],
                'bio'=> $validator['bio'],
            ];

            if ($request->has('password') && !empty($request->input('password'))) {
                $data['password'] = Hash::make($request->input('password'));
            }

            $data = DB::table('users')->where('id',$auth_user->id)->update($user_data);

            if($data){
                Session::flash('success','Your profile updated successfully');
                return redirect()->route('profile',$auth_user->username);
            }else{
                return redirect()->route('profile',$auth_user->username);
            }

        }catch (Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }


    public function changePassword()
    {
        return view('user.change-password');
    }


    public function passwordUpdate(Request $request)
    {

        $auth_user = Auth::user();
        if(Hash::check($request->input('current_password'),$auth_user->password)){

           $validate = $request->validate([
               'new_password' => 'required|min:6|max:15',
               'confirm_password' => 'required|same:new_password',
           ]);

           if(Hash::check($request->input('new_password'),$auth_user->password)) {
               Session::flash('error','New Password can not same the current password!');
               return back();
           }

           DB::table('users')->where('id',Auth::id())->update(['password'=>Hash::make($validate['new_password'])]);

           Session::flash('success', 'Password updated successfully');
           return redirect()->route('profile',$auth_user->username);
       }
       else{
           Session::flash('error','Current password does not match our records!');
           return back();
       }
    }


}
