<?php

namespace App\Service;

use App\Model\User;

class Authorization
{
    private string $login;
    private string $password;

    function __construct()
    {
        $this->login = htmlspecialchars($_POST['login']);
        $this->password = htmlspecialchars($_POST['password']);
    }

    public function login(): bool
    {
        $user = User::where('email', '=', $this->login)->first();
        
        if ($user && password_verify($this->password, $user->password)) {
            $_SESSION['user'] = $user->toArray();
            $_SESSION['isAuth'] = true;
            $_SESSION['errorLogin'] = false;
            return true;
        }

        $_SESSION['isAuth'] = false;
        $_SESSION['errorLogin'] = true;

        return false;
    }
}