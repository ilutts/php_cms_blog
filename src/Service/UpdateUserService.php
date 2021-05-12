<?php

namespace App\Service;

use App\Model\RoleUserRepository;
use App\Model\User;
use App\Model\UserRepository;

class UpdateUserService
{
    private User $user;

    private array $update = [];

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getError(): array
    {
        return $this->user->errorUpdate ?? [];
    }

    public function info(string $name, string $email, string $about, array $image)
    {
        $name = strip_tags($name);
        $email = strip_tags($email);
        $about = strip_tags($about);

        $validateServices = new ValidateService();

        if ($this->user->name !== $name && $validateServices->checkText($name, 'name', 3)) {
            $this->update['name'] = $name;
        }

        if ($this->user->email !== $email && $validateServices->checkEmail($email)) {
            $this->update['email'] = $email;
        }

        if ($this->user->about !== $about) {
            $this->update['about'] = $about;
        }

        if (!empty($image['name']) && $validateServices->checkImage($image)) {
            move_uploaded_file(
                $image['tmp_name'],
                $_SERVER['DOCUMENT_ROOT'] . UPLOAD_USER_DIR . $image['name']
            );

            $this->update['image'] = UPLOAD_USER_DIR . rawurlencode($image['name']);
        }

        if ($validateServices->getError()) {
            $this->user->errorUpdate = $validateServices->getError();
            return false;
        }

        if ($this->update && UserRepository::update($this->user->id, $this->update)) {
            foreach ($this->update as $key => $value) {
                $_SESSION['user'][$key] = $value;
            }
        }
    }

    public function password(string $passwordOld, string $passwordNew1, string $passwordNew2)
    {
        $passwordOld = strip_tags($passwordOld);
        $passwordNew1 = strip_tags($passwordNew1);
        $passwordNew2 = strip_tags($passwordNew2);

        $validateServices = new ValidateService();

        if ($validateServices->checkUpdatePassword($passwordOld, $this->user->password, $passwordNew1, $passwordNew2)) {
            $this->update['password'] = password_hash($passwordNew1, PASSWORD_DEFAULT);
        }

        if ($validateServices->getError()) {
            $this->user->errorUpdate = $validateServices->getError();
            return false;
        }

        if ($this->update) {
            UserRepository::update($this->user->id, $this->update);
        }
    }

    public function signed()
    {
        if (UserRepository::update($this->user->id, ['signed' => !$this->user->signed])) {
            $_SESSION['user']['signed'] = !$this->user->signed;
        }
    }

    public function actived(bool $actived)
    {
        if ($this->user->id !== 1 && $this->user->actived !== $actived) {
            UserRepository::update($this->user->id, ['actived' => $actived]);
        }
    }

    public function roles(array $rolesId)
    {
        if ($rolesId && $this->user->id !== ADMIN_ID) {
            RoleUserRepository::deleteAll($this->user->id);

            foreach ($rolesId as $roleId) {
                RoleUserRepository::add($this->user->id, (int)$roleId);
            }
        }
    }
}
