<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $table = 'static_pages';

    protected $fillable = [
        'title',
        'body',
        'name',
        'actived',
    ];
}
