<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle an registration.
     *
     * @param  RegisterRequest $request
     *
     * @return ResponseJson
     */
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::once($credentials))
        {
            $credentials['password'] = bcrypt($credentials['password']);
            $user = User::create($credentials);
            $token = $user->createToken($request->userAgent())->plainTextToken;
            return response()->json(compact('user', 'token'));
        }
        return response()->json(['message' => 'Email is not available.'], 422);
    }

    /**
     * Handle an authentication user.
     *
     * @param LoginRequest $request
     *
     * @return ResponseJson
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::once($credentials))
        {
            $user = Auth::user();
            $token = $user->createToken($request->userAgent())->plainTextToken;
            return response()->json(compact('user', 'token'));
        }
        return response()->json(['message' => 'Incorrect username or password.'], 422);
    }
}
