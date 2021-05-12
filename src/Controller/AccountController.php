<?php

namespace App\Controller;

use App\Model\UnregisteredSubscriberRepository;
use App\Model\User;
use App\Model\UserRepository;
use App\Service\AuthorizationService;
use App\Service\RegistrationUserService;
use App\Service\SubscriberService;
use App\Service\UpdateUserService;
use App\View\View;
use stdClass;

class AccountController extends Controller
{
    public function login()
    {
        return new View('login', [
            'header' => $this->getInfoForHeader(),
            'main' => [],
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function logout()
    {
        unset($_SESSION['isAuth']);
    
        setcookie(session_name(), session_id(), time() - 60 * 60 * 24, '/');
    
        session_destroy();
    
        header('Location: /');
    }

    public function authorization()
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            AuthorizationService::login($_POST['login'], $_POST['password']);
        }

        header('Location: /login');
    }

    public function registration()
    {
        if (!empty($_SESSION['error']['registration'])) {
            $error = $_SESSION['error']['registration'];
            unset($_SESSION['error']['registration']);
        }

        return new View('registration', [
            'header' => $this->getInfoForHeader(),
            'main' => $error ?? [],
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function addNewUser()
    {
        if (isset($_POST['submit-reg'])) {
            $registration = new RegistrationUserService();
            $registration->add(
                $_POST['name'],
                $_POST['email'],
                $_POST['password1'],
                $_POST['password2'],
                isset($_POST['rule'])
            );

            if ($registration->getError()) {
                $_SESSION['error']['registration'] = $registration->getError();
            }
        }

        header('Location: /registration');
    }

    public function profile()
    {
        if (!empty($_SESSION['isAuth'])) {
            $user = User::find($_SESSION['user']['id']);

            if (!empty($_SESSION['error']['user'])) {
                $user->error = $_SESSION['error']['user'];
                unset($_SESSION['error']['user']);
            }

            if (!empty($_SESSION['success']['user'])) {
                $user->success = $_SESSION['success']['user'];
                unset($_SESSION['success']['user']);
            }
        }

        return new View('profile', [
            'header' => $this->getInfoForHeader(),
            'main' => $user ?? [],
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function updatePassword()
    {
        if (!empty($_SESSION['isAuth']) && isset($_POST['submit-password'])) {
            $user = User::find($_SESSION['user']['id']);

            $updateUser = new UpdateUserService($user);
            $updateUser->password(
                $_POST['password_old'] ?? '',
                $_POST['password1'] ?? '',
                $_POST['password2'] ?? '',
            );

            if ($updateUser->getError()) {
                $_SESSION['error']['user'] = $updateUser->getError();
            } else {
                $_SESSION['success']['user']['update_pass'] = true;
            }
        }

        header('Location: /profile');
    }

    public function updateInfo()
    {
        if (!empty($_SESSION['isAuth']) && isset($_POST['submit-info'])) {
            $user = User::find($_SESSION['user']['id']);

            $updateUser = new UpdateUserService($user);
            $updateUser->info(
                $_POST['name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['about'] ?? '',
                $_FILES['image'] ?? [],
            );

            if ($updateUser->getError()) {
                $_SESSION['error']['user'] = $updateUser->getError();
            } else {
                $_SESSION['success']['user']['update_info'] = true;
            }
        }

        header('Location: /profile');
    }

    public function updateSigned()
    {
        if (!empty($_SESSION['isAuth']) && isset($_POST['submit-signed'])) {
            $user = User::find($_SESSION['user']['id']);

            $updateUser = new UpdateUserService($user);
            $updateUser->signed();

            $_SESSION['success']['user']['update_signed'] = true;
        }

        header('Location: /profile');
    }

    public function subscribe()
    {
        if (isset($_POST['submit-signed'])) {
            if (isset($_POST['email'])) {
                $subscriberServices = new SubscriberService();
                $subscriberServices->newUnregistered($_POST['email']);
                
                if ($subscriberServices->getError()) {
                    $_SESSION['error']['subscriber'] = $subscriberServices->getError();
                } else {
                    $_SESSION['success']['subscriber'] = $subscriberServices->getSuccess();
                }

            } else {
                $user = User::findOrFail($_SESSION['user']['id']);
                $updateUser = new UpdateUserService($user);
                $updateUser->signed();
            }
        }

        header('Location: /');
    }

    public function unsubscribe(string $userType, int $userId)
    {
        $userType = strip_tags($userType);

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
