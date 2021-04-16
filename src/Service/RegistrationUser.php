<?php

namespace App\Service;

use App\Model\RoleUserRepository;
use App\Model\UserRepository;

class RegistrationUser
{
    private string $inputName;
    private string $inputEmail;
    private string $inputPassword1;
    private string $inputPassword2;
    private bool $rule;

    private array $error = [];

    function __construct()
    {
        $this->inputName = htmlspecialchars($_POST['name']);
        $this->inputEmail = htmlspecialchars($_POST['email']);
        $this->inputPassword1 = htmlspecialchars($_POST['password1']);
        $this->inputPassword2 = htmlspecialchars($_POST['password2']);
        $this->rule = isset($_POST['rule']);
    }

    public function new()
    {
        if ($this->validate()) {
            $newUser = UserRepository::add($this->inputEmail, password_hash($this->inputPassword1, PASSWORD_DEFAULT), $this->inputName);
            
            if ($newUser->wasRecentlyCreated) {
                RoleUserRepository::add($newUser->id, 3);
                $auth = new Authorization($this->inputEmail, $this->inputPassword1);
                $auth->login();
            } else {
                $this->error['email'] = 'Почта уже использовалась ранее!';
            }
        }

        return $this->error ? (object)$this->error : [];
    }

    private function validate(): bool
    {
        $validateService = new ValidateServices();

        $validateService->checkText($this->inputName, 'name', 3);
        $validateService->checkEmail($this->inputEmail);
        $validateService->checkPassword($this->inputPassword1, $this->inputPassword2);
        $validateService->checkRule($this->rule);

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            $this->error['nameOldValue'] = $this->inputName;
            $this->error['emailOldValue'] = $this->inputEmail;
            return false;
        }

        return true;
    }
}