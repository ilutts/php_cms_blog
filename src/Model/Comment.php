<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text',
        'post_id',
        'user_id',
        'approved'
    ];

    public function post()
    {
        return $this->belongsTo('App\Model\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
