<?php

namespace App\Service;

use App\Model\RoleUserRepository;
use App\Model\UnregisteredSubscriber;
use App\Model\UnregisteredSubscriberRepository;
use App\Model\UserRepository;

class RegistrationUserService
{
    private array $error = [];

    public function getError(): array
    {
        return $this->error;
    }

    public function add(string $name, string $email, string $password1, string $password2, bool $rule)
    {
        $name = strip_tags($name);
        $email = strip_tags($email);
        $password1 = strip_tags($password1);
        $password2 = strip_tags($password2);

        if ($this->validate($name, $email, $password1, $password2, $rule)) {
            $newUser = UserRepository::add($email, password_hash($password1, PASSWORD_DEFAULT), $name);

            if ($newUser->wasRecentlyCreated) {
                if (UnregisteredSubscriber::where('email', $email)->exists()) {
                    UserRepository::update($newUser->id, ['signed' => 1]);
                    UnregisteredSubscriberRepository::deleteByEmail($email);
                }

                RoleUserRepository::add($newUser->id, REGISTERED_USER_GROUP);
                AuthorizationService::login($email, $password1);
            } else {
                $this->error['email'] = 'Почта уже использовалась ранее!';
            }
        }
    }

    private function validate(string $name, string $email, string $password1, string $password2, bool $rule): bool
    {
        $validateService = new ValidateService();

        $validateService->checkText($name, 'name', 3);
        $validateService->checkEmail($email);
        $validateService->checkPassword($password1, $password2);
        $validateService->checkRule($rule);

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            $this->error['nameOldValue'] = $name;
            $this->error['emailOldValue'] = $email;
            return false;
        }

        return true;
    }
}
