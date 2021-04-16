<?php

namespace App\Service;

use App\Model\User;
use App\Model\UserRepository;

class UpdateUser
{
    private User $user;

    private string $inputName;
    private string $inputEmail;
    private string $inputPassword1;
    private string $inputPassword2;
    private string $inputAbout;
    private array $inputImage;
    private string $inputPasswordOld;

    private array $update = [];

    function __construct(User $user)
    {
        $this->user = $user;

        $this->inputName = htmlspecialchars($_POST['name'] ?? '');
        $this->inputEmail = htmlspecialchars($_POST['email'] ?? '');
        $this->inputAbout = htmlspecialchars($_POST['about'] ?? '');
        $this->inputImage = $_FILES['image'] ?? [];

        $this->inputPasswordOld = htmlspecialchars($_POST['password_old'] ?? '');
        $this->inputPassword1 = htmlspecialchars($_POST['password1'] ?? '' );
        $this->inputPassword2 = htmlspecialchars($_POST['password2'] ?? '');
    }
    public function info(): User
    {
        $validateServices = new ValidateServices();

        if ($this->user->name !== $this->inputName && $validateServices->checkText($this->inputName, 'name', 3)) {
            $this->update['name'] = $this->inputName;
        }

        if ($this->user->email !== $this->inputEmail && $validateServices->checkEmail($this->inputEmail)) {
            $this->update['email'] = $this->inputEmail;
        }

        if ($this->user->about !== $this->inputAbout) {
            $this->update['about'] = $this->inputAbout;
        }
    
        if ($validateServices->checkImage($this->inputImage)) {
            move_uploaded_file(
                $this->inputImage['tmp_name'], 
                $_SERVER['DOCUMENT_ROOT'] . UPLOAD_USER_DIR . $this->inputImage['name']
            );

            $this->update['image'] = UPLOAD_USER_DIR . $this->inputImage['name'];
        }

        if ($validateServices->getError()) {
            $this->user->errorUpdate = (object)$validateServices->getError();
            return $this->user;
        }

        if ($this->update && UserRepository::update($this->user->id, $this->update)) {
            $this->user->updateInfo = true;
            foreach ($this->update as $key => $value) {
                $_SESSION['user'][$key] = $value;
                $this->user[$key] = $value;
            }
        }

        return $this->user; 
    }

    public function password(): User
    {
        $validateServices = new ValidateServices();

        if ($validateServices->checkUpdatePassword($this->inputPasswordOld, $this->user->password, $this->inputPassword1, $this->inputPassword2)) {
            $this->update['password'] = password_hash($this->inputPassword1, PASSWORD_DEFAULT);
        }

        if ($validateServices->getError()) {
            $this->user->errorUpdate = (object)$validateServices->getError();
            return $this->user;
        }

        if ($this->update && UserRepository::update($this->user->id, $this->update)) {
            $this->user->updatePassword = true;
        }

        return $this->user;
    }

    public function signed(): User
    {
        if (UserRepository::update($this->user->id, ['signed' => !$this->user->signed])) {
            $_SESSION['user']['signed'] = !$this->user->signed;
            $this->user->signed = !$this->user->signed;
            $this->user->updateSigned = true;
        }

        return $this->user;
    }
}