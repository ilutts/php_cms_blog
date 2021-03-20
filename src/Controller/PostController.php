<?php

namespace App\Controller;

use App\Model\Menu;
use App\Model\Post;
use App\Model\User;
use App\Service\UpdateUser;
use App\View\View;

class PostController
{
    public function mainView(): View
    {
        if (isset($_POST['submit-signed'])) {
            $user = User::find($_SESSION['user']['id']);
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

    public function postView(string $id): View
    {
        $id = (int)$id;

        $post = Post::where('id', '=', $id)->with('comments.user')->first();

        return new View('post', [
            'header' => Menu::all(), 
            'main' => $post,
            'footer' => [], 
        ]);
    }
}
