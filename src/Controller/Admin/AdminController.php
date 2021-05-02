<?php

namespace App\Controller\Admin;

use App\Config;
use App\Controller\Controller;
use App\Exception\NoAccessException;
use App\Model\AdminMenu;
use App\Model\RoleUser;

abstract class AdminController extends Controller
{
    protected function checkAccess(array $allowedUsersByRoleId = [ADMIN_GROUP])
    {
        if (empty($_SESSION['isAuth'])) {
            throw new NoAccessException('Вы не авторизованы!', 500);
        }

        $roles = RoleUser::where('user_id', $_SESSION['user']['id'])->whereIn('role_id', $allowedUsersByRoleId)->exists();

        if (!$roles) {
            throw new NoAccessException('У вас нет прав доступа!', 500);
        }
    }

    protected function getInfoForAdminHeader()
    {
        return [
            'title' => Config::getInstance()->get('cms.site_name'),
            'menu' => AdminMenu::all()
        ];
    }
}
