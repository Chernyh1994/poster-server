<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that should be guarded for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'name', 'mime', 'size'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     *  Get the owning imagetable model.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
