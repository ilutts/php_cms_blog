<?php

namespace App\Controller;

use App\Model\Role;
use App\Model\UnregisteredSubscriber;
use App\Model\UnregisteredSubscriberRepository;
use App\Model\User;
use App\Model\UserRepository;
use App\Service\Authorization;
use App\Service\RegistrationUser;
use App\Service\UpdateUser;
use App\View\JsonView;
use App\View\View;
use stdClass;

class AccountController extends Controller
{
    public function loginView()
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $auth = new Authorization($_POST['login'], $_POST['password']);
            $auth->login();
        }

        return new View('login', [
            'header' => $this->getInfoForHeader(),
            'main' => [],
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function registrationView()
    {
        if (isset($_POST['submit-reg'])) {
            $registration = new RegistrationUser();
            $info = $registration->new();
        }

        return new View('registration', [
            'header' => $this->getInfoForHeader(),
            'main' => $info ?? false,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function profileView()
    {
        if (!empty($_SESSION['isAuth'])) {
            $user = User::find($_SESSION['user']['id']);

            if (isset($_POST['submit-info'])) {
                $updateUser = new UpdateUser($user);
                $user = $updateUser->info();
            }

            if (isset($_POST['submit-password'])) {
                $updateUser = new UpdateUser($user);
                $user = $updateUser->password();
            }

            if (isset($_POST['submit-signed'])) {
                $updateUser = new UpdateUser($user);
                $user = $updateUser->signed();
            }
        }

        return new View('profile', [
            'header' => $this->getInfoForHeader(),
            'main' => $user ?? false,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function unsubscribeView(string $userType, int $userId)
    {
        $userType = htmlspecialchars($userType);

        switch ($userType) {
            case 'reg':
                UserRepository::update($userId, ['signed' => 0]);
                break;

            case 'unreg':
                UnregisteredSubscriberRepository::update($userId, ['signed' => 0]);
                break;

            default:
                break;
        }

        $data = new stdClass;
        $data->title = 'Отписка от рассылки';
        $data->body = 'Вы успешно исключены из расслыки сообщений о новых статьях';


        return new View('static', [
            'header' => $this->getInfoForHeader(),
            'main' => $data,
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
}
