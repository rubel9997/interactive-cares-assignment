<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function profile(Request $request)
    {

        $user = User::with('posts')->where('username', $request->username)->first();

        return view('user.profile', ['user' => $user]);
    }

    public function edit(Request $request)
    {
        return view('user.edit');
    }

    public function update(UserUpdateRequest $request)
    {
        try {
            $validator = $request->validated();

            $auth_user = User::find(Auth::id());

            $user_data = [
                'first_name' => $validator['first_name'],
                'last_name' => $validator['last_name'],
                'bio' => $validator['bio'],
            ];

            if ($request->has('password') && ! empty($request->input('password'))) {
                $user_data['password'] = Hash::make($request->input('password'));
            }

            $status = $auth_user->update($user_data);

            if ($request->has('avatar')) {
                $auth_user->clearMediaCollection();
                $auth_user->addMediaFromRequest('avatar')->toMediaCollection();
            }

            if ($status) {
                Session::flash('success', 'Your profile updated successfully');

                return redirect()->route('profile', $auth_user->username);
            } else {
                return redirect()->route('profile', $auth_user->username);
            }

        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function changePassword()
    {
        return view('user.change-password');
    }

    public function passwordUpdate(Request $request)
    {

        $auth_user = Auth::user();
        if (Hash::check($request->input('current_password'), $auth_user->password)) {

            $validate = $request->validate([
                'new_password' => 'required|min:6|max:15',
                'confirm_password' => 'required|same:new_password',
            ]);

            if (Hash::check($request->input('new_password'), $auth_user->password)) {
                Session::flash('error', 'New Password can not same the current password!');

                return back();
            }

            User::where('id', Auth::id())->update(['password' => Hash::make($validate['new_password'])]);

            Session::flash('success', 'Password updated successfully');

            return redirect()->route('profile', $auth_user->username);
        } else {
            Session::flash('error', 'Current password does not match our records!');

            return back();
        }
    }
}
