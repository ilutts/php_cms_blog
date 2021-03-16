<?php

namespace App\Service;

use App\Model\UserRepository;

class Registration
{
    private string $name;
    private string $email;
    private string $password1;
    private string $password2;
    private bool $rule;
    private $error = [];

    function __construct()
    {
        $this->name = htmlspecialchars($_POST['name']);
        $this->email = htmlspecialchars($_POST['email']);
        $this->password1 = htmlspecialchars($_POST['password1']);
        $this->password2 = htmlspecialchars($_POST['password2']);
        $this->rule = isset($_POST['rule']);
    }

    public function new(): array
    {
        if ($this->validate()) {
           UserRepository::add($this->email, password_hash($this->password1, PASSWORD_DEFAULT), $this->name);
        }

        return $this->error;
    }

    private function validate(): bool
    {
        if (mb_strlen($this->name) < 3) {
            $this->error['name'] = $this->name;
        }

        if (stripos($this->email, '@') < 1 ) {
            $this->error['email'] = $this->email;
        }

        if (mb_strlen($this->password1) < 3 || $this->password1 !== $this->password2) {
            $this->error['password'] = '';
        }

        if (!$this->rule) {
            $this->error['rule'] = false;
        }

        return $this->error ? false : true;
    }
}