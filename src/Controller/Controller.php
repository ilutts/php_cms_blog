<?php

namespace App\Controller;

use App\Model\Menu;
use App\Model\Post;
use App\Service\Authorization;
use App\Service\Registration;
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

    public function loginView(): View
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $auth = new Authorization();
            $auth->login();
        }

        return new View('login', [
            'header' => Menu::all(), 
            'main' => [],
            'footer' => [], 
        ]);
    }

    public function registrationView(): View
    {
        $info = [];

        if (isset($_POST['submit-reg'])) {
            $registration = new Registration();
            $info = $registration->new();
        }

        return new View('registration', [
            'header' => Menu::all(), 
            'main' => $info,
            'footer' => [], 
        ]);
    }
}
