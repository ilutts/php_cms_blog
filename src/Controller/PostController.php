<?php

namespace App\Controller;

use App\Model\Menu;
use App\Model\Post;
use App\Model\User;
use App\Service\CommentServices;
use App\Service\UpdateUser;
use App\View\View;

class PostController
{
    public function mainView()
    {
        if (isset($_POST['submit-signed'])) {
        $user = User::findOrFail($_SESSION['user']['id']);
            $updateUser = new UpdateUser($user);
            $updateUser->signed();
        }

        $posts = Post::with('comments')->orderByDesc('created_at')->get();

        return new View('index', [
            'header' => Menu::all(), 
            'main' => $posts,
            'footer' => [], 
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
            'header' => Menu::all(), 
            'main' => $post,
            'footer' => [], 
        ]);
    }
}
