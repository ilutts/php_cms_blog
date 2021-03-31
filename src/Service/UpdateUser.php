<?php

namespace App\Service;

use App\Model\User;
use App\Model\UserRepository;

class UpdateUser extends ValidateServices
{
    private User $user;

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
        if ($this->user->name !== $this->inputName && $this->validateName($this->inputName)) {
            $this->update['name'] = $this->inputName;
        }

        if ($this->user->email !== $this->inputEmail && $this->validateEmail($this->inputEmail)) {
            $this->update['email'] = $this->inputEmail;
        }

        if ($this->user->about !== $this->inputAbout) {
            $this->update['about'] = $this->inputAbout;
        }
    
        if ($this->validateImage($this->inputImage)) {
            move_uploaded_file(
                $this->inputImage['tmp_name'], 
                $_SERVER['DOCUMENT_ROOT'] . UPLOAD_USER_DIR . $this->inputImage['name']
            );

            $this->update['image'] = UPLOAD_USER_DIR . $this->inputImage['name'];
        }

        if ($this->error) {
            $this->user->errorUpdate = $this->error;
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
        if ($this->validateUpdatePassword($this->inputPasswordOld, $this->inputPassword1, $this->inputPassword2)) {
            $this->update['password'] = password_hash($this->inputPassword1, PASSWORD_DEFAULT);
        }

        if ($this->error) {
            $this->user->errorUpdate = $this->error;
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

    private function validateImage(array $fileImg): bool
    {
        if ($fileImg['error'] === 4) {
            return false;
        }

        // Максимальный размер файла
        $maxFileSize = 5242880;
    
        // Разрешенные типы файлов для загрузки
        $checkedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    
        if ($fileImg['error'] !== 0) {
            $this->error['image'] = 'Ошибка загрузки изображения';
            return false;
        }
    
        if (filesize($fileImg['tmp_name']) > $maxFileSize) {
            $this->error['image'] = 'Превышен допустимый размер файла';
            return false;
        }
    
        if (!checkTypeFile($fileImg['tmp_name'], $checkedTypes)) {
            $this->error['image'] = 'Неправильный формат файла';
            return false;
        }
    
        return true;
    }

    private function validateUpdatePassword(string $oldPassword, string $newPassword1, string $newPassword2): bool
    {
        if (password_verify($oldPassword, $this->user->password)) {
            $this->error['password-old'] = 'Неверно указан старый пароль';
        }

        $this->validatePassword($newPassword1, $newPassword2);

        return $this->error ? false : true;
    }
}