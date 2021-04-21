<?php

namespace App\Controller;

use App\Exception\NoAccessException;
use App\Model\CommentRepository;
use App\Model\RoleUser;
use App\Model\UnregisteredSubscriberRepository;
use App\Model\User;
use App\Model\UserRepository;
use App\Service\CommentServices;
use App\Service\ConfigsServices;
use App\Service\PostServices;
use App\Service\StaticPageServices;
use App\Service\SubscriberServices;
use App\Service\UpdateUser;
use App\Service\UsersServices;
use App\View\View;

class AdminController extends Controller
{
    private function checkAccess(array $allowedUsersByRoleId = [1])
    {
        if (empty($_SESSION['isAuth'])) {
            throw new NoAccessException('Вы не авторизованы!', 500);
        }

        $roles = RoleUser::where('user_id', $_SESSION['user']['id'])->whereIn('role_id', $allowedUsersByRoleId)->exists();

        if (!$roles) {
            throw new NoAccessException('У вас нет прав доступа!', 500);
        }
    }

    public function mainView()
    {
        $this->checkAccess([1, 2]);

        if (isset($_POST['submit_post'])) {
            $postServices = new PostServices();

            if ($_POST['submit_post'] === 'new') {
                $postServices->new((int)$_SESSION['user']['id']);
            }

            if ($_POST['submit_post'] === 'change') {
                $postServices->change((int)$_SESSION['user']['id']);
            }
        }

        $posts = PostServices::get('admin');

        if (isset($postServices) && $postServices->getError()) {
            $posts->error = $postServices->getError();
        }

        return new View('admin/main', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $posts,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function usersView()
    {
        $this->checkAccess();

        if (isset($_POST['submit_user'])) {
            $user = User::findOrFail((int)$_POST['id']);
            $updateUser = new UpdateUser($user);
            $updateUser->info();
            $updateUser->actived();
            $updateUser->roles();
        }

        $users = UsersServices::get();

        if (isset($updateUser) && $updateUser->getError()) {
            $user->error = $updateUser->getError();
        }

        return new View('admin/users', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $users,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function signedsView()
    {
        $this->checkAccess();

        if (isset($_POST['reg_user'])) {
            UserRepository::update((int)$_POST['id'], ['signed' => !(int)$_POST['signed']]);
        }

        if (isset($_POST['unreg_user'])) {
            UnregisteredSubscriberRepository::update((int)$_POST['id'], ['signed' => !(int)$_POST['signed']]);
        }

        $users = SubscriberServices::get();

        return new View('admin/signeds', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $users,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function commentsView()
    {
        $this->checkAccess([1, 2]);

        if (isset($_POST['comment_approved'])) {
            CommentRepository::update((int)$_POST['id'], ['approved' => !(int)$_POST['approved']]);
        }

        $comments = CommentServices::get();

        return new View('admin/comments', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $comments,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function staticsView()
    {
        $this->checkAccess([1, 2]);

        if (isset($_POST['submit_post'])) {
            $staticPageServices = new StaticPageServices();

            if ($_POST['submit_post'] === 'new') {
                $staticPageServices->new();
            }

            if ($_POST['submit_post'] === 'change') {
                $staticPageServices->change();
            }
        }

        $staticsPage = StaticPageServices::get();

        if (isset($staticPageServices) && $staticPageServices->getError()) {
            $staticsPage->error = $staticPageServices->getError();
        }

        return new View('admin/statics', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $staticsPage,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function settingsView()
    {
        $this->checkAccess();

        if (isset($_POST['submit-setting'])) {
            ConfigsServices::set();
        }

        $settings = ConfigsServices::get();

        return new View('admin/settings', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $settings,
            'footer' => $this->getInfoForFooter(),
        ]);
    }
}
