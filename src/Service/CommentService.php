<?php

namespace App\Service;

use App\Model\Comment;
use App\Model\CommentRepository;
use App\Model\RoleUser;

class CommentService
{
    private string $error = '';

    public static function getForAdmin(int $numberSkipItems, int $maxItemsOnPage)
    {
        return Comment::orderBy('approved', 'asc')->orderBy('id', 'desc')->skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }

    public function add(string $text, int $postId, int $userId)
    {
        if (empty($_SESSION['isAuth'])) {
            return 'Вы не авторизованы';
        }

        $text = strip_tags($text);
        $approved = false;
        $textSuccess = 'Комментарий будет добавлен после проверки';

        if (RoleUser::where('user_id', $userId)->whereIn('role_id', [ADMIN_GROUP, CONTENT_MANAGER_GROUP])->exists()) {
            $approved = true;
            $textSuccess = 'Комментарий добавлен';
        }

        if ($this->validate($text)) {
            CommentRepository::add($text, $postId, $userId, $approved);
            return $textSuccess;
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
