<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\V1\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Handle an authorized user profile.
     *
     * @return ResponseJson
     */
    public function myProfile()
    {
        $user = Auth::user()->load('profile');

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
        $user = User::with('profile')->findOrFail($id);

        return response()->json(compact('user'));
    }

    /**
     * Update user profile.
     *
     * @param UpdateUserRequest $request
     * 
     * @return ResponseJson
     */
    public function update(UpdateUserRequest $request)
    {    
        $updateTransaction = DB::transaction(function () use ($request) {
            $data = $request->validated(); 
            $user = Auth::user();
            $avatar = $request->file('avatar');

            $user->update($data);
        
            if($avatar) {
                if($user->profile['avatar_name']) {
                    Storage::disk('public')->delete('upload/avatars/'.$user->profile->avatar_name);
                }
                
                $avatar->store('upload/avatars', 'public');

                $name = $avatar->hashName();
                $path = asset('storage/upload/avatars/'.$name);
    
                $user->profile()->updateOrCreate([],[
                    'avatar_path' => $path,
                    'avatar_name' => $name,
                ]);
            };
            $user->refresh();
            return response()->json(compact('user'));
        });

        return $updateTransaction;
    }
}
