<?php

namespace App\Controller;

use App\Model\UnregisteredSubscriberRepository;
use App\Model\User;
use App\Model\UserRepository;
use App\Service\AuthorizationService;
use App\Service\RegistrationUserService;
use App\Service\UpdateUserService;
use App\View\View;
use stdClass;

class AccountController extends Controller
{
    public function loginView()
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            AuthorizationService::login($_POST['login'], $_POST['password']);
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
            $registration = new RegistrationUserService();
            $info = $registration->add(
                $_POST['name'],
                $_POST['email'],
                $_POST['password1'],
                $_POST['password2'],
                isset($_POST['rule'])
            );
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
                $updateUser = new UpdateUserService($user);
                $user = $updateUser->info(
                    $_POST['name'] ?? '',
                    $_POST['email'] ?? '',
                    $_POST['about'] ?? '',
                    $_FILES['image'] ?? [],
                );
            }

            if (isset($_POST['submit-password'])) {
                $updateUser = new UpdateUserService($user);
                $user = $updateUser->password(
                    $_POST['password_old'] ?? '',
                    $_POST['password1'] ?? '',
                    $_POST['password2'] ?? '',
                );
            }

            if (isset($_POST['submit-signed'])) {
                $updateUser = new UpdateUserService($user);
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
}
