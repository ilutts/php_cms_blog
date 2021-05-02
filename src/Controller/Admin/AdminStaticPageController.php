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
    public function staticPagesView()
    {
        $this->checkAccess([ADMIN_GROUP, CONTENT_MANAGER_GROUP]);

        if (isset($_POST['delete_page']) && StaticPage::findOrFail((int)$_POST['id'])) {
            StaticPageRepository::delete((int)$_POST['id']);
            MenuRepository::delete((int)$_POST['id']);
        }

        if (isset($_POST['submit_post'])) {
            $staticPageServices = new StaticPageService();

            if ($_POST['submit_post'] === 'new') {
                $staticPageServices->add(
                    $_POST['title'] ?? '',
                    $_POST['name'] ?? '',
                    $_POST['body'] ?? '',
                );
            }

            if ($_POST['submit_post'] === 'change') {
                $staticPageServices->update(
                    $_POST['id'] ?? 0,
                    $_POST['title'] ?? '',
                    $_POST['name'] ?? '',
                    $_POST['body'] ?? '',
                    boolval($_POST['post_actived'] ?? 0),
                );
            }
        }

        $pagination = new PaginationService(
            StaticPage::count(),
            $_GET['quantity'] ?? 20,
            $_GET['page'] ?? 1
        );

        $staticPages = StaticPageService::get($pagination->getNumberSkipItem(), $pagination->getMaxItemOnPage());

        if (isset($staticPageServices) && $staticPageServices->getError()) {
            $staticPages->error = $staticPageServices->getError();
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
}
