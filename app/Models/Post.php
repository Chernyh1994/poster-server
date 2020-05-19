<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content'
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
     * Get the user that owns the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
    /**
     * Get all of the post's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imagetable');
    }

    /**
     * Get all of the like's posts.
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'liketable');
    }
}
