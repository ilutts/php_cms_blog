<?php

namespace App\Service;

use App\Model\CommentRepository;
use App\Model\RoleUser;

class CommentServices
{
    private int $postId;
    private string $text;
    private bool $approved = false;

    private string $error = '';

    public function __construct(int $postId)
    {
        $this->userId = (int)$_SESSION['user']['id'] ?? 0;
        $this->postId = $postId;
        $this->text = htmlspecialchars($_POST['comment-new'] ?? '');
    }

    public function new()
    {
        if (empty($_SESSION['isAuth'])) {
            return 'Вы не авторизованы';
        }

        if (RoleUser::where('user_id', $this->userId)->whereIn('role_id', [1, 2])->exists()) {
            $this->approved = true;
        }

        if ($this->validate($this->text)) {
            CommentRepository::add($this->text, $this->postId, $this->userId, $this->approved);
            return 'Комментарий добавлен';
        }

        return $this->error;
    }

    private function validate(string $text)
    {
        if (mb_strlen($text) < 3) {
            $this->error = 'Слишком короткий текст';
            return false;
        }

        return true;
    }
}