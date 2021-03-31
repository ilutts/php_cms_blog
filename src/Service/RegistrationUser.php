<?php

namespace App\Service;

use App\Model\RoleUserRepository;
use App\Model\UserRepository;

class RegistrationUser extends ValidateServices
{
    private bool $rule;

    function __construct()
    {
        $this->inputName = htmlspecialchars($_POST['name']);
        $this->inputEmail = htmlspecialchars($_POST['email']);
        $this->inputPassword1 = htmlspecialchars($_POST['password1']);
        $this->inputPassword2 = htmlspecialchars($_POST['password2']);
        $this->rule = isset($_POST['rule']);
    }

    public function new(): array
    {
        if ($this->validate()) {
            $newUser = UserRepository::add($this->inputEmail, password_hash($this->inputPassword1, PASSWORD_DEFAULT), $this->inputName);
            
            if ($newUser->wasRecentlyCreated) {
                RoleUserRepository::add($newUser->id, 3);
                $auth = new Authorization($this->inputEmail, $this->inputPassword1);
                $auth->login();
            } else {
                $this->error['email']['text'] = 'Почта уже использовалась ранее!';
            }
        }

        return $this->error;
    }

    private function validate(): bool
    {
        $this->validateName($this->inputName);
        $this->validateEmail($this->inputEmail);
        $this->validatePassword($this->inputPassword1, $this->inputPassword2);
        $this->validateRule($this->rule);

        if ($this->error) {
            $this->error['name-value'] = $this->inputName;
            $this->error['email-value'] = $this->inputEmail;
            return false;
        }

        return true;
    }

    private function validateRule(bool $rule)
    {
        if (!$rule) {
            $this->error['rule'] = 'Не отмечано прочтение правил';
        }
    }
}