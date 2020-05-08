<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Requests\V1\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Handle an authorized user profile.
     *
     * @return ResponseJson
     */
    public function myProfile()
    {
        $user = User::with('images')->findOrFail(Auth::id());
        return response()->json(compact('user'));
    }

    /**
     * Handle an user profile.
     * 
     * @param  int  $id
     * 
     * @return ResponseJson
     */
    public function userProfile($id)
    {
        $user = User::with('images')->findOrFail($id);
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
        $user = Auth::user();
        $data = $request->validated();
        if($request->file('avatar')) {
            $path = $request->file('avatar')->store('upload/avatars', 'public');
            // $test = Storage::url($request->file('avatar')->hashName());
            $test = Storage::disk('public')->path($request->file('avatar')->hashName());
            // $test = $request->file('avatar')->hashName();

            $user->images()->create([
                'path' => $path,
                'name' => $test,
                'mime' => $request->file('avatar')->getMimeType(),
                'size' => $request->file('avatar')->getSize(),
            ]);
            // $url = Storage::url();
            // $request->file('avatar')->getClientOriginalName(),
        };
        $user->fill($data)->save();
        return response()->json(compact('user'));
    }
}
