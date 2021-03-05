<?php

namespace App\Controller;

use App\Model\Menu;
use App\Model\Post;
use App\View\View;

class Controller
{
    public function mainView(): View
    {
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
