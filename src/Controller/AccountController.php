<?php 

namespace App\Controller;

use App\Model\Menu;
use App\Model\User;
use App\Service\Authorization;
use App\Service\RegistrationUser;
use App\Service\UpdateUser;
use App\View\View;

class AccountController
{   
    public function loginView(): View
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $auth = new Authorization($_POST['login'], $_POST['password']);
            $auth->login();
        }

        return new View('login', [
            'header' => Menu::all(), 
            'main' => [],
            'footer' => [], 
        ]);
    }

    public function registrationView(): View
    {
        if (isset($_POST['submit-reg'])) {
            $registration = new RegistrationUser();
            $info = $registration->new();
        }

        return new View('registration', [
            'header' => Menu::all(), 
            'main' => $info ?? false,
            'footer' => [], 
        ]);
    }

    public function profileView(): View
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
            'header' => Menu::all(), 
            'main' => $user ?? false,
            'footer' => [], 
        ]);
    }
}