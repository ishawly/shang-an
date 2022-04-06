<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) {
            return $this->error(
                'Unprocessable Entity',
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $validator->errors()->getMessages()
            );
        }

        if (! auth()->attempt($validator->validated())) {
            return $this->error('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        $user = auth()->user();
        $token = $user->createToken('api');

        return $this->success([
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
            // 'expires_in' => 60, // TODO:: fill right expire time
        ]);
    }

    public function logout()
    {
        // need assign 'auth:sanctum' middleware
        $user = auth()->user();
        // revoke all tokens...
        $user->tokens()->delete();

        // $user->currentAccessToken()->delete();;

        return $this->successMessage('User successfully signed out');
    }

    public function userProfile()
    {
        $user = auth()->user();

        return $this->success($user);
    }
}
