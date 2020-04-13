<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'images_path', 'post_id', 'comment_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function comments()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }}
