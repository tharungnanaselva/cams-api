<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->validated())) {
            return $this->errorResponse('Invalid credentials', null, 401);
        }

        $user = Auth::user();

        $token = $user->createToken('cams')->plainTextToken;

        return $this->successResponse([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 'Login successful');
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->successResponse(
            null,
            'Logout successful'
        );
    }
}
