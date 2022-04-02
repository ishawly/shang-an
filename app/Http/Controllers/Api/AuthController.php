<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();
        $token = $user->createToken('api');

        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
            'expires_in' => 60, // TODO:: fill right expire time
        ];
    }

    public function logout()
    {
        // need assign 'auth:sanctum' middleware
        $user = auth()->user();
        // revoke all tokens...
        $user->tokens()->delete();

        // $user->currentAccessToken()->delete();;

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile()
    {
        $user = auth()->user();

        return response()->json($user);
    }
}
