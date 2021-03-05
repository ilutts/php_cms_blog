<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'email',
        'password',
        'name'
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Model\Role');
    }

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }
}