<?php

namespace App\Controller;

use App\Config;
use App\Exception\NotFoundException;
use App\Model\Post;
use App\Model\User;
use App\Service\CommentService;
use App\Service\PaginationService;
use App\Service\PostService;
use App\Service\SubscriberService;
use App\Service\UpdateUserService;
use App\View\View;

class PostController extends Controller
{
    public function postsView()
    {
        if (isset($_POST['submit-signed'])) {
            if (isset($_POST['email'])) {
                $subscriberServices = new SubscriberService();
                $subscriberServices->newUnregistered($_POST['email']);
            } else {
                $user = User::findOrFail($_SESSION['user']['id']);
                $updateUser = new UpdateUserService($user);
                $updateUser->signed();
            }
        }

        $pagination = new PaginationService(
            Post::where('actived', 1)->count(),
            Config::getInstance()->get('cms.quantity_posts_main') ?? 1,
            $_GET['page'] ?? 1
        );

        $posts = PostService::get($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        if (isset($subscriberServices)) {
            if ($subscriberServices->getError()) {
                $posts->errorForm = $subscriberServices->getError();
            }

            if ($subscriberServices->getSuccess()) {
                $posts->successForm = $subscriberServices->getSuccess();
            }
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

    public function postView(int $postId)
    {
        if (!empty($_POST['comment-new'])) {
            $comment = new CommentService();
            $comment = $comment->add(
                $_POST['comment-new'] ?? '',
                $postId,
                $_SESSION['user']['id'] ?? 0,
            );
        }

        $post = Post::where('id', $postId)->with(['comments' => function ($query) {
            $query->where('approved', 1);
        }])->first();

        if (!$post) {
            throw new NotFoundException('Статья не найдена!');
        }

        $post->newСomment = $comment ?? false;

        return new View('post', [
            'header' => $this->getInfoForHeader(),
            'main' => $post,
            'footer' => $this->getInfoForFooter(),
        ]);
    }
}
