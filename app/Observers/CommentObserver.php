<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentObserver
{
    /**
     * Handle the comment "creating" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        if(!$comment->author_id){
            $comment->author_id = Auth::id();
        }
    }
}
