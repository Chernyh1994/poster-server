<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\User;
// use Laravel\Sanctum\NewAccessTokenplainTextTokenNewAccessToken;

class AuthController extends Controller
{

    protected function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    protected function token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();
        $password = Hash::check($request->password, $user->password);

        if (!$user || !$password) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    protected function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'lougout error'], 401);
        }

        $user->tokens()->delete();
        return response('Loggedout', 200);
    }

    protected function name(Request $request)
    {
        return response()->json(['name' => $request->user()->name]);
    }

}