<?php

namespace App\Controller;

use App\Exception\NoAccessException;
use App\Model\AdminMenu;
use App\Model\RoleUser;
use App\Model\User;
use App\Service\PostServices;
use App\Service\UpdateUser;
use App\Service\UsersServices;
use App\View\View;

class AdminController
{
    private function checkAccess()
    {
        if (empty($_SESSION['isAuth'])) {
            throw new NoAccessException('Вы не авторизованы!', 500);
        }

        $roles = RoleUser::where('user_id', $_SESSION['user']['id'])->whereIn('role_id', [1, 2])->get();

        if (!$roles) {
            throw new NoAccessException('У вас нет прав доступа!', 500);
        }
    }

    public function mainView()
    {
        $this->checkAccess();

        $postServices = new PostServices();

        if (isset($_POST['submit_post'])) {

            if ($_POST['submit_post'] === 'new') {
                $postServices->new((int)$_SESSION['user']['id']);
            }

            if ($_POST['submit_post'] === 'change') {
                $postServices->change((int)$_SESSION['user']['id']);
            }
        }

        $posts = $postServices->get('admin');

        return new View('admin/main', [
            'header' => AdminMenu::all(),
            'main' => $posts,
            'footer' => [],
        ]);
    }

    public function usersView()
    {
        $this->checkAccess();

        $usersServices = new UsersServices();

        if (isset($_POST['submit_user'])) {
            $user = User::findOrFail((int)$_POST['id']);
            $updateUser = new UpdateUser($user);
            $updateUser->info();
            $updateUser->actived();
        }

        $users = $usersServices->get();

        return new View('admin/users', [
            'header' => AdminMenu::all(),
            'main' => $users,
            'footer' => [],
        ]);
    }
}
