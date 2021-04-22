<?php

namespace App\Service;

use App\Model\User;

class UsersService
{
    public static function get(int $numberSkipItems, int $maxItemsOnPage)
    {
        return User::select('id', 'email', 'name', 'created_at', 'actived')->with('roles')->orderByDesc('id')->skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }
}
