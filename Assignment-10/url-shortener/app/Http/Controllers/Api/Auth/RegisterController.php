<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Authentication successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], Response::HTTP_CREATED);
    }
}
