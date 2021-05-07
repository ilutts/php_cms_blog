<?php

namespace App\Controller\Admin;

use App\Model\Comment;
use App\Model\CommentRepository;
use App\Service\CommentService;
use App\Service\PaginationService;
use App\View\View;

class AdminCommentController extends AdminController
{
    public function comments()
    {
        $this->checkAccess([ADMIN_GROUP, CONTENT_MANAGER_GROUP]);

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

    public function approvedComment()
    {
        if (isset($_POST['comment_approved'])) {
            CommentRepository::update((int)$_POST['comment_approved'], ['approved' => !(int)$_POST['approved']]);
        }

        header('Location: /admin/comments');
    }

    public function deleteComment()
    {
        if (isset($_POST['delete_comment']) && Comment::findOrFail((int)$_POST['delete_comment'])) {
            CommentRepository::delete((int)$_POST['delete_comment']);
        }

        header('Location: /admin/comments');
    }
}
