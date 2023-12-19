<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function sendEmail()
    {
        Mail::to(auth()->user())->send(new EmailVerification(auth()->user()));

        return response()->json([
           'message'=>'Email verification link sent to your email.'
        ]);
    }

    public function verifyEmail(Request $request)
    {
        if(!$request->user()->email_verified_at){
           $request->user()->forceFill(['email_verified_at'=> now()])->save();
        }

        return response()->json([
            'message'=>'Email verified',
        ]);
    }
}
