<?php

namespace App\Controller\Admin;

use App\Model\Post;
use App\Model\PostRepository;
use App\Service\PaginationService;
use App\Service\PostService;
use App\View\JsonView;
use App\View\View;

class AdminPostController extends AdminController
{
    public function posts()
    {
        $this->checkAccess([ADMIN_GROUP, CONTENT_MANAGER_GROUP]);

        if (isset($_POST['delete_post']) && Post::findOrFail((int)$_POST['id'])) {
            PostRepository::delete((int)$_POST['id']);
        }

        $pagination = new PaginationService(
            Post::count(),
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $posts = PostService::getForAdmin($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());
   
        if (!empty($_SESSION['error']['post'])) {
            $posts->error = $_SESSION['error']['post'];
            unset($_SESSION['error']['post']);
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

    public function addPost()
    {
        if (isset($_POST['submit_post']) && $_POST['submit_post'] === 'new') {
            $postServices = new PostService();
            
            $postServices->add(
                $_POST['title'] ?? '',
                $_POST['short_description'] ?? '',
                $_POST['description'] ?? '',
                $_SESSION['user']['id'],
                $_FILES['image'] ?? [],
                isset($_POST['post_actived']),
            );

            if ($postServices->getError()) {
                $_SESSION['error']['post']['add'] = $postServices->getError();
            }
        }

        header('Location: /admin');
    }

    public function updatePost()
    {
        if (isset($_POST['submit_post']) && $_POST['submit_post'] === 'change') {
            $postServices = new PostService();
            
            $postServices->update(
                $_POST['id'] ?? 0,
                $_POST['title'] ?? '',
                $_POST['short_description'] ?? '',
                $_POST['description'] ?? '',
                $_SESSION['user']['id'],
                $_FILES['image'] ?? [],
                isset($_POST['post_actived']),
            );

            if ($postServices->getError()) {
                $_SESSION['error']['post']['update'] = $postServices->getError();
            }
        }

        header('Location: /admin');
    }

    public function deletePost()
    {
        if (isset($_POST['delete_post']) && Post::findOrFail((int)$_POST['delete_post'])) {
            PostRepository::delete((int)$_POST['delete_post']);
        }

        header('Location: /admin');
    }
}
