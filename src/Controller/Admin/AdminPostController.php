<?php

namespace App\Controller\Admin;

use App\Config;
use App\Model\Post;
use App\Service\PaginationService;
use App\Service\PostService;
use App\View\JsonView;
use App\View\View;

class AdminPostController extends AdminController
{
    public function postsView()
    {
        $this->checkAccess([1, 2]);

        if (isset($_POST['submit_post'])) {
            $postServices = new PostService();

            if ($_POST['submit_post'] === 'new') {
                $postServices->new((int)$_SESSION['user']['id']);
            }

            if ($_POST['submit_post'] === 'change') {
                $postServices->change((int)$_SESSION['user']['id']);
            }
        }

        $pagination = new PaginationService(
            Post::count(),
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $posts = PostService::get($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        if (isset($postServices) && $postServices->getError()) {
            $posts->error = $postServices->getError();
        }

        return new View('admin/posts', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => [
                'posts' => $posts,
                'count_pages' => $pagination->getCountPages(),
            ],
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
