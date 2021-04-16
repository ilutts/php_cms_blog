<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'description',
        'user_id',
        'actived',
        'image'
    ];

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
