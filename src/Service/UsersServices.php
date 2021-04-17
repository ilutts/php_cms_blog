<?php

namespace App\Service;

use App\Model\User;

class UsersServices
{
    public function get()
    {
        $countPosts = (int)User::count();
        $maxUsersOnPage = $_GET['quantity'] ?? 20;

        if ($maxUsersOnPage === 'all') {
            $maxUsersOnPage = $countPosts;
        } else {
            $maxUsersOnPage = (int)$maxUsersOnPage;
        }

        $skipPosts = 0;

        if (!empty($_GET['page']) && $_GET['page'] > 1) {
            $page = (int)$_GET['page'];
            $skipPosts = $page * $maxUsersOnPage - $maxUsersOnPage;
        }

        $users = User::select('id', 'email', 'name', 'created_at', 'actived')->with('roles')->orderByDesc('id')->skip($skipPosts)->take($maxUsersOnPage)->get();
        $users->countPages = ceil($countPosts / $maxUsersOnPage);

        return $users;
    }
}
