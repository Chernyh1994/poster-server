<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'liketable_id', 'liketable_type'
    ];

    /**
     * Get the user that owns the like.
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owning liketable model.
     */
    public function liketable()
    {
        return $this->morphTo();
    }
}
