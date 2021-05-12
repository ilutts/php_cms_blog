<?php

namespace App\Controller;

use App\Config;
use App\Exception\NotFoundException;
use App\Model\Post;
use App\Service\CommentService;
use App\Service\PaginationService;
use App\Service\PostService;
use App\View\View;

class PostController extends Controller
{
    public function posts()
    {
        $pagination = new PaginationService(
            Post::where('actived', 1)->count(),
            Config::getInstance()->get('cms.quantity_posts_main') ?? 1,
            $_GET['page'] ?? 1
        );

        $posts = PostService::get($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        if (isset($_SESSION['error']['subscriber'])) {
            $posts->errorForm = $_SESSION['error']['subscriber'];
            unset($_SESSION['error']['subscriber']);
        }

        if (isset($_SESSION['success']['subscriber'])) {
            $posts->successForm = $_SESSION['success']['subscriber'];
            unset($_SESSION['error']['subscriber']);
        }

        return new View('posts', [
            'header' => $this->getInfoForHeader(),
            'main' => [
                'posts' => $posts,
                'count_pages' => $pagination->getCountPages(),
            ],
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function post(int $postId)
    {
        $post = Post::where('id', $postId)->with(['comments' => function ($query) {
            $query->where('approved', 1);
        }])->first();

        if (!$post) {
            throw new NotFoundException('Статья не найдена!');
        }

        if (isset($_SESSION['comment']['new'])) {
            $post->newСomment = $_SESSION['comment']['new'];
            unset($_SESSION['comment']['new']);
        }

        return new View('post', [
            'header' => $this->getInfoForHeader(),
            'main' => $post,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function newComment()
    {
        if (!empty($_POST['comment-new'])) {
            $postId = intval($_POST['post_id'] ?? 0);

            $comment = new CommentService();
            $comment = $comment->add(
                $_POST['comment-new'] ?? '',
                $postId,
                $_SESSION['user']['id'] ?? 0,
            );

            $_SESSION['comment']['new'] = $comment;

            header("Location: /post/{$postId}");
        }
    }
}
