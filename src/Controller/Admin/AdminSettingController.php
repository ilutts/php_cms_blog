<?php

namespace App\Controller\Admin;

use App\Service\ConfigsService;
use App\View\View;

class AdminSettingController extends AdminController
{
    public function settingsView()
    {
        $this->checkAccess();

        if (isset($_POST['submit-setting'])) {
            ConfigsService::set(
                $_POST['site_name'] ?? 'CMS-blog',
                $_POST['quantity_posts_main'] ?? 5,
                isset($_POST['mailing_list']),
            );
        }

        $settings = ConfigsService::get();

        return new View('admin/settings', [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $settings,
            'footer' => $this->getInfoForFooter(),
        ]);
    }
}
