<?php

namespace App\Service;

class ValidateServices
{
    private array $error = [];

    public function getError(): array
    {
        return $this->error;
    }

    public function checkText(string $text, string $fieldName, int $length = 3): bool
    {
        if (mb_strlen($text) < $length) {
            $this->error[$fieldName] = 'Длина текста меньше ' . $length;
            return false;
        }

        return true;
    }

    public function checkEmail(string $email): bool
    {
        if (stripos($email, '@') < 1) {
            $this->error['email'] = 'Неправильно заполнена почта';
            return false;
        }

        return true;
    }

    public function checkPassword(string $password1, string $password2): bool
    {
        if (mb_strlen($password1) < 3 || $password1 !== $password2) {
            $this->error['passwordNew'] = 'Неверно заполнен новый пароль или пароли не совпадают';
            return false;
        }

        return true;
    }

    public function checkUpdatePassword(string $inputOldPassword, string $userPassword, string $newPassword1, string $newPassword2): bool
    {
        if (!password_verify($inputOldPassword, $userPassword)) {
            $this->error['passwordOld'] = 'Неверно указан старый пароль';
            return false;
        }

        return $this->checkPassword($newPassword1, $newPassword2);
    }

    public function checkRule(bool $rule): bool
    {
        if (!$rule) {
            $this->error['rule'] = 'Не отмечано прочтение правил';
            return false;
        }

        return true;
    }

    public function checkImage(array $fileImg): bool
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

    public function checkTextForLink(string $text, string $fieldName)
    {
        if (preg_match('/[^a-z0-9]/', $text)) {
            $this->error[$fieldName] = 'Только латиница и цифры!';
            return false;
        }

        return true;
    }
}
