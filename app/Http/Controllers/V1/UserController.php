<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\V1\Auth\UpdateUserRequest;
use Illuminate\Support\Arr;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Handle an authorized user profile.
     *
     * @param Request $request
     *
     * @return ResponseJson
     */
    public function myProfile(Request $request)
    {
        $user = Auth::user();
        return response()->json(compact('user'));
    }

    /**
    * Update user.
    *
    * @param UpdateUserRequest $request
    *
    * @return ResponseJson
    */
    public function update(UpdateUserRequest $request)
    {
        $user = User::findOrFail(Auth::id());
        $data = $request->validated();
        if($request->file('avatar')){
            $path = $request->file('avatar')->store('upload/avatars', 'public');
            $data = Arr::add($data, 'avatar_path', $path);
        }
        $user->fill($data)->save();
        return response()->json(compact('user'));
    }

    /**
    * Handle an user profile.
    *
    * @return ResponseJson
    */
    public function userProfile($id)
    {
        $user = User::findOrFail($id);
        return response()->json(compact('user'));
    }
}
