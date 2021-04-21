<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UnregisteredSubscriber extends Model
{
    protected $table = 'unregistered_subscribers';

    protected $fillable = [
        'email'
    ];
}
