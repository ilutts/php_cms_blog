<?php

namespace App\Service;

use App\Model\User;

class AuthorizationService
{
    public static function login(string $login, string $password): bool
    {
        $login = strip_tags($login);
        $password = strip_tags($password);

        $user = User::where('email', $login)->with('roles')->first();

        if (!$user) {
            $_SESSION['isAuth'] = false;
            $_SESSION['errorLogin'] = 'Пользователя с таким логином не существует!';
            return false;
        }

        if (!$user->actived) {
            $_SESSION['isAuth'] = false;
            $_SESSION['errorLogin'] = 'Пользователь с таким логином заблокирован!';
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->attributesToArray();
            $_SESSION['roles'] = $user->roles->keyBy('id')->toArray();
            $_SESSION['isAuth'] = true;
            $_SESSION['errorLogin'] = false;
            return true;
        }

        $_SESSION['isAuth'] = false;
        $_SESSION['errorLogin'] = 'Неверный пароль!';

        return false;
    }
}
