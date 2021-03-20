<?php

namespace App\Service;

class ValidateServices
{
    protected string $inputName;
    protected string $inputEmail;
    protected string $inputPassword1;
    protected string $inputPassword2;

    protected array $error = [];

    protected function validateName(string $name): bool
    {
        if (mb_strlen($name) < 3) {
            $this->error['name'] = 'Неправильно заполнено имя';
            return false;
        }

        return true;
    }

    protected function validateEmail(string $email): bool
    {
        if (stripos($this->inputEmail, '@') < 1 ) {
            $this->error['email'] = 'Неправильно заполнена почта';
            return false;
        }

        return true;
    }

    protected function validatePassword(string $password1, string $password2): bool
    {
        if (mb_strlen($password1) < 3 || $password1 !== $password2) {
            $this->error['password-new'] = 'Неверно заполнен новый пароль или пароли не совпадают';
            return false;
        }

        return true;
    }
}