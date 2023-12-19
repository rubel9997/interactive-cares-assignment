<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::with('urls')->where('id',auth()->user()->id)->first();
        return response()->json([
            'user'=> new UserResource($user),
        ]);
    }
}
