<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name',
        'short_description',
        'description',
        'img'
    ];

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }
}