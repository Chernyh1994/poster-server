<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
        $token = $user->createToken($request->userAgent())->plainTextToken;
        return response()->json(compact('user', 'token'));
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
        if (!Auth::once($credentials))
        {
            return response()->json(['message' => 'The selected password is invalid.'], 422);
        }
        $user = Auth::user();
        $token = $user->createToken($request->userAgent())->plainTextToken;
        return response()->json(compact('user', 'token'));
    }
   /**
     * Handle an  user.
     *
     * @param Request $request
     *
     * @return ResponseJson
     */
   public function name(Request $request)
   {
        $user = Auth::user();
        return response()->json(compact('user'));
   }
}
