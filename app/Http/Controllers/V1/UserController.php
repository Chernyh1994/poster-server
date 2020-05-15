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
        $user = User::with('avatar')->findOrFail(Auth::id());

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
        $user = User::with('avatar')->findOrFail($id);

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
        $data = $request->validated(); 
        $user = Auth::user();
        $avatar = $request->file('avatar');

        DB::beginTransaction();

        try {
            $user->update($data);

            if($avatar) {

                if($user->avatar) {
                    Storage::disk('public')->delete('upload/avatars/'.$user->avatar->name);
                }
                
                $avatar->store('upload/avatars', 'public');

                $name = $avatar->hashName();
                $path = asset('storage/upload/avatars/'.$name);
    
                $user->avatar()->updateOrCreate([],[
                    'path' => $path,
                    'name' => $name,
                    'mime' => $avatar->getMimeType(),
                    'size' => $avatar->getSize(),
                ]);
            };
                
            DB::commit();
            $user->refresh();
            
            return response()->json(compact('user'));
        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json(['message' => 'Something went wrong try again.'], 422);
        }
    }
}
