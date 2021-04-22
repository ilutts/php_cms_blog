<?php

namespace App\Service;

use App\Model\RoleUserRepository;
use App\Model\UnregisteredSubscriber;
use App\Model\UnregisteredSubscriberRepository;
use App\Model\UserRepository;

class RegistrationUserService
{
    private string $name;
    private string $email;
    private string $password1;
    private string $password2;
    private bool $rule;

    private array $error = [];

    public function add(string $name, string $email, string $password1, string $password2, bool $rule)
    {
        $this->name = htmlspecialchars($name);
        $this->email = htmlspecialchars($email);
        $this->password1 = htmlspecialchars($password1);
        $this->password2 = htmlspecialchars($password2);
        $this->rule = $rule;

        if ($this->validate()) {
            $newUser = UserRepository::add($this->email, password_hash($this->password1, PASSWORD_DEFAULT), $this->name);

            if ($newUser->wasRecentlyCreated) {
                if (UnregisteredSubscriber::where('email', $this->email)->exists()) {
                    UserRepository::update($newUser->id, ['signed' => 1]);
                    UnregisteredSubscriberRepository::delete($this->email);
                }

                RoleUserRepository::add($newUser->id, 3);
                AuthorizationService::login($this->email, $this->password1);
            } else {
                $this->error['email'] = 'Почта уже использовалась ранее!';
            }
        }

        return $this->error ? (object)$this->error : [];
    }

    private function validate(): bool
    {
        $validateService = new ValidateService();

        $validateService->checkText($this->name, 'name', 3);
        $validateService->checkEmail($this->email);
        $validateService->checkPassword($this->password1, $this->password2);
        $validateService->checkRule($this->rule);

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            $this->error['nameOldValue'] = $this->name;
            $this->error['emailOldValue'] = $this->email;
            return false;
        }

        return true;
    }
}
