<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the like.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Like  $like
     * @return mixed
     */
    public function unlike(User $user, Like $like)
    {
        return $user->id === $like->author_id;
    }
}
