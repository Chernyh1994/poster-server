<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    /**
     * Get the user that owns the comment.
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the subcomment that owns the comment.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Get all of the comment's subcomments.
     */
    public function subcomments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get all of the like's comments.
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'liketable');
    }
}
