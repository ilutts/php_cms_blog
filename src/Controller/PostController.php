<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\User;
use App\Service\CommentServices;
use App\Service\PostServices;
use App\Service\SubscriberServices;
use App\Service\UpdateUser;
use App\View\JsonView;
use App\View\View;

class PostController extends Controller
{
    public function mainView()
    {
        if (isset($_POST['submit-signed'])) {
            if (isset($_POST['email'])) {
                $subscriberServices = new SubscriberServices();
                $subscriberServices->newUnregistered();
            } else {
                $user = User::findOrFail($_SESSION['user']['id']);
                $updateUser = new UpdateUser($user);
                $updateUser->signed();
            }
        }

        $posts = PostServices::get();

        if (isset($subscriberServices)) {
            if ($subscriberServices->getError()) {
                $posts->errorForm = $subscriberServices->getError();
            }

            if ($subscriberServices->getSuccess()) {
                $posts->successForm = $subscriberServices->getSuccess();
            }
        }

        return new View('index', [
            'header' => $this->getInfoForHeader(),
            'main' => $posts,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function postView(int $id)
    {
        if (!empty($_POST['comment-new'])) {
            $comment = new CommentServices($id);
            $comment = $comment->new();
        }

        $post = Post::where('id', $id)->with(['comments' => function ($query) {
            $query->where('approved', 1);
        }])->first();

        $post->newСomment = $comment ?? false;

        return new View('post', [
            'header' => $this->getInfoForHeader(),
            'main' => $post,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function ajaxGetPost()
    {
        $id = intval($_POST['id'] ?? 0);
        if ($id) {
            $post = Post::where('id', $id)->with('user')->first();

            return new JsonView($post);
        }
    }
}
