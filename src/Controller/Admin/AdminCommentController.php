<?php

namespace App\Controller\Admin;

use App\Model\Comment;
use App\Model\CommentRepository;
use App\Service\CommentService;
use App\Service\PaginationService;
use App\View\View;

class AdminCommentController extends AdminController
{
    public function commentsView()
    {
        $this->checkAccess([1, 2]);

        if (isset($_POST['comment_approved'])) {
            CommentRepository::update((int)$_POST['id'], ['approved' => !(int)$_POST['approved']]);
        }

        $pagination = new PaginationService(
            Comment::count(),
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $comments = CommentService::getForAdmin($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        return new View('admin/comments', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => [
                'comments' => $comments,
                'count_pages' => $pagination->getCountPages(),
            ],
            'footer' => $this->getInfoForFooter(),
        ]);
    }
}
