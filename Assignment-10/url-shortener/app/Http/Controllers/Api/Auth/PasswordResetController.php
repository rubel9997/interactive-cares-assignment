<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PasswordResetController extends Controller
{

    public function sendResetLinkEmail(LinkEmailRequest $request)
    {
        $appUrl = env('APP_URL');
        $frontendUrl = env('FRONTEND_URL');

        $url = URL::temporarySignedRoute('password.reset', now()->addMinutes(30), ['email' => $request->email]);

        $urlReplaced = str_replace($appUrl, $frontendUrl, $url);

        Mail::to($request->email)->send(new ResetPasswordLink($urlReplaced));

        return response()->json(['message' => 'Reset Password sent to mail']);
    }


    public function reset(ResetPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if(!$user){
            return response()->json(['message'=>'User does not exists our records'],response::HTTP_UNAUTHORIZED);
        }

        $user->password =Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password Reset Successfully.'],response::HTTP_OK);
    }


}
