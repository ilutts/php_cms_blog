<?php

namespace App\Controller\Admin;

use App\Model\Role;
use App\Model\UnregisteredSubscriber;
use App\Model\UnregisteredSubscriberRepository;
use App\Model\User;
use App\Model\UserRepository;
use App\Service\PaginationService;
use App\Service\SubscriberService;
use App\Service\UpdateUserService;
use App\Service\UsersService;
use App\View\JsonView;
use App\View\View;

class AdminUserController extends AdminController
{
    public function usersView()
    {
        $this->checkAccess();

        if (isset($_POST['delete_user']) && User::findOrFail((int)$_POST['id']) && (int)$_POST['id'] !== ADMIN_ID) {
            UserRepository::delete((int)$_POST['id']);
        }

        if (isset($_POST['submit_user'])) {
            $user = User::findOrFail((int)$_POST['id']);
            $updateUser = new UpdateUserService($user);
            $updateUser->info(
                $_POST['name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['about'] ?? '',
                $_FILES['image'] ?? [],
            );
            $updateUser->actived($_POST['user_actived'] ?? 0);
            $updateUser->roles($_POST['roles'] ?? []);
        }

        $pagination = new PaginationService(
            User::count(),
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $users = UsersService::get($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        if (isset($updateUser) && $updateUser->getError()) {
            $user->error = $updateUser->getError();
        }

        return new View('admin/users', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => [
                'users' => $users,
                'count_pages' => $pagination->getCountPages(),
            ],
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function ajaxGetUser()
    {
        $id = intval($_POST['id'] ?? 0);
        if ($id) {
            $user = User::where('id', $id)->with('roles')->first();
            $user->allroles = Role::all();

            return new JsonView($user);
        }
    }

    public function signedsView()
    {
        $this->checkAccess();

        if (isset($_POST['delete_unreg_signed']) && UnregisteredSubscriber::findOrFail((int)$_POST['id'])) {
            UnregisteredSubscriberRepository::deleteById((int)$_POST['id']);
        }

        if (isset($_POST['reg_user'])) {
            UserRepository::update((int)$_POST['id'], ['signed' => !(int)$_POST['signed']]);

            if ((int)$_SESSION['user']['id'] === (int)$_POST['id']) {
                $_SESSION['user']['signed'] = !$_SESSION['user']['signed'];
            }
        }

        if (isset($_POST['unreg_user'])) {
            UnregisteredSubscriberRepository::update((int)$_POST['id'], ['signed' => !(int)$_POST['signed']]);
        }

        $countRegisteredUsers = (int)User::count();
        $countUnregisteredUsers = (int)UnregisteredSubscriber::count();

        $pagination = new PaginationService(
            $countRegisteredUsers > $countUnregisteredUsers ? $countRegisteredUsers : $countUnregisteredUsers,
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $registeredUsers = SubscriberService::getRegisteredUsers($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());
        $unregisteredUsers = SubscriberService::getUnregisteredUsers($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        return new View('admin/signeds', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => [
                'registered_users' => $registeredUsers,
                'unregistered_users' => $unregisteredUsers,
                'count_pages' => $pagination->getCountPages(),
            ],
            'footer' => $this->getInfoForFooter(),
        ]);
    }
}
