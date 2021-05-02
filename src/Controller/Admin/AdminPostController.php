<?php

namespace App\Controller\Admin;

use App\Config;
use App\Model\Post;
use App\Model\PostRepository;
use App\Service\PaginationService;
use App\Service\PostService;
use App\View\JsonView;
use App\View\View;

class AdminPostController extends AdminController
{
    public function postsView()
    {
        $this->checkAccess([ADMIN_GROUP, CONTENT_MANAGER_GROUP]);

        if (isset($_POST['delete_post']) && Post::findOrFail((int)$_POST['id'])) {
            PostRepository::delete((int)$_POST['id']);
        }

        if (isset($_POST['submit_post'])) {
            $postServices = new PostService();

            if ($_POST['submit_post'] === 'new') {
                $postServices->add(
                    $_POST['title'] ?? '',
                    $_POST['short_description'] ?? '',
                    $_POST['description'] ?? '',
                    $_SESSION['user']['id'],
                    $_FILES['image'] ?? [],
                    isset($_POST['post_actived']),
                );
            }

            if ($_POST['submit_post'] === 'change') {
                $postServices->update(
                    $_POST['id'] ?? 0,
                    $_POST['title'] ?? '',
                    $_POST['short_description'] ?? '',
                    $_POST['description'] ?? '',
                    $_SESSION['user']['id'],
                    $_FILES['image'] ?? [],
                    isset($_POST['post_actived']),
                );
            }
        }

        $pagination = new PaginationService(
            Post::count(),
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $posts = PostService::getForAdmin($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

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
