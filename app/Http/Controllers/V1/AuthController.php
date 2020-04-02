<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle an authentication once.
     *
     * @param  Request  $request
     *
     * @return Response
     */

    public function register(RegisterRequest $request)
    {
        $credentials = $request->only('name', 'email', 'password');

        if (!Auth::once($credentials))
        {
            $credentials['password'] = bcrypt($credentials['password']);
            $user = User::create($credentials);
            $token = $user->createToken($request->userAgent())->plainTextToken;
            return response()->json(compact('user', 'token'));
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::once($credentials))
        {
            $user = Auth::user();
            $token = $user->createToken($request->userAgent())->plainTextToken;
            return response()->json(compact('user', 'token'));
        }
    }

}
