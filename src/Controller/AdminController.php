<?php

namespace App\Controller;

use App\Exception\NoAccessException;
use App\Model\Menu;
use App\Model\Post;
use App\Model\RoleUser;
use App\Service\PostServices;
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
            'header' => Menu::all(),
            'main' => $posts,
            'footer' => [],
        ]);
    }
}
