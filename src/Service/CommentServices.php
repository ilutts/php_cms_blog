<?php

namespace App\Service;

use App\Model\Comment;
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
        $this->userId = intval($_SESSION['user']['id'] ?? 0);
        $this->postId = $postId;
        $this->text = htmlspecialchars($_POST['comment-new'] ?? '');
    }

    public static function get()
    {
        $countPosts = (int)Comment::count();
        $maxItemOnPage = $_GET['quantity'] ?? 20;

        if ($maxItemOnPage === 'all') {
            $maxItemOnPage = $countPosts;
        } else {
            $maxItemOnPage = (int)$maxItemOnPage;
        }

        $skipPosts = 0;

        if (!empty($_GET['page']) && $_GET['page'] > 1) {
            $page = (int)$_GET['page'];
            $skipPosts = $page * $maxItemOnPage - $maxItemOnPage;
        }

        $comments = Comment::orderBy('approved', 'asc')->orderBy('id', 'desc')->skip($skipPosts)->take($maxItemOnPage)->get();
        $comments->countPages = ceil($countPosts / $maxItemOnPage);

        return $comments;
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