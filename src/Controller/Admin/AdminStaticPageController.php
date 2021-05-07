<?php

namespace App\Controller\Admin;

use App\Model\MenuRepository;
use App\Model\StaticPage;
use App\Model\StaticPageRepository;
use App\Service\PaginationService;
use App\Service\StaticPageService;
use App\View\JsonView;
use App\View\View;

class AdminStaticPageController extends AdminController
{
    public function staticPages()
    {
        $this->checkAccess([ADMIN_GROUP, CONTENT_MANAGER_GROUP]);

        $pagination = new PaginationService(
            StaticPage::count(),
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $staticPages = StaticPageService::get($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        if (!empty($_SESSION['error']['statics'])) {
            $staticPages->error = $_SESSION['error']['statics'];
            unset($_SESSION['error']['statics']);
        }

        return new View('admin/statics', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => [
                'static_pages' => $staticPages,
                'count_pages' => $pagination->getCountPages(),
            ],
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function ajaxGetStaticPage()
    {
        $id = intval($_POST['id'] ?? 0);

        if ($id) {
            $page = StaticPage::findOrFail($id);

            return new JsonView($page);
        }
    }

    public function addStaticPage()
    {
        if (isset($_POST['submit_post']) && $_POST['submit_post'] === 'new') {
            $staticPageServices = new StaticPageService();

            $staticPageServices->add(
                $_POST['title'] ?? '',
                $_POST['name'] ?? '',
                $_POST['body'] ?? '',
            );

            if ($staticPageServices->getError()) {
                $_SESSION['error']['statics']['add'] = $staticPageServices->getError();
            }
        }

        header('Location: /admin/statics');
    }

    public function updateStaticPage()
    {
        if (isset($_POST['submit_post']) && $_POST['submit_post'] === 'change') {
            $staticPageServices = new StaticPageService();

            $staticPageServices->update(
                $_POST['id'] ?? 0,
                $_POST['title'] ?? '',
                $_POST['name'] ?? '',
                $_POST['body'] ?? '',
                boolval($_POST['post_actived'] ?? 0),
            );

            if ($staticPageServices->getError()) {
                $_SESSION['error']['statics']['update'] = $staticPageServices->getError();
            }
        }

        header('Location: /admin/statics');
    }

    public function deleteStaticPage()
    {
        if (isset($_POST['delete_page']) && StaticPage::findOrFail((int)$_POST['delete_page'])) {
            StaticPageRepository::delete((int)$_POST['delete_page']);
            MenuRepository::delete((int)$_POST['delete_page']);
        }

        header('Location: /admin/statics');
    }
}
