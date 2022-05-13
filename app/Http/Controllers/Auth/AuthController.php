<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $credentials = $loginRequest->validated();
        if (!Auth::attempt($credentials)) {
            return $this->error([], 'Credentials not match', 401);
        }

        return $this->success(['token' => auth()->user()->createToken('API Token')->plainTextToken], "Login successful");
    }
}
