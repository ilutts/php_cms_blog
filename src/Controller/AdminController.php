<?php

namespace App\Controller;

use App\Exception\NoAccessException;
use App\Model\Menu;
use App\Model\RoleUser;
use App\View\View;

class AdminController
{
    public function mainView()
    {
        if (empty($_SESSION['isAuth'])) {
            throw new NoAccessException('Вы не авторизованы!', 500);
        }

        $roles = RoleUser::where('user_id', $_SESSION['user']['id'])->whereIn('role_id', [1, 2])->get();
        
        if (!$roles) {
            throw new NoAccessException('У вас нет прав доступа!', 500);
        }

        return new View('admin/main', [
            'header' => Menu::all(), 
            'main' => [],
            'footer' => [], 
        ]);
    }
}