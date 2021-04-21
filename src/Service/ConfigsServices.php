<?php

namespace App\Service;

use App\Config;

class ConfigsServices
{
    public static function get()
    {
        $configs = [
            'site_name' => Config::getInstance()->get('cms.site_name'),
            'quantity_posts_main' => Config::getInstance()->get('cms.quantity_posts_main'),
            'mailing_list' => Config::getInstance()->get('cms.mailing_list'),
        ];

        return $configs;
    }

    public static function set()
    {
        $siteName = htmlspecialchars($_POST['site_name'] ?? 'CMS-blog');
        $quantityPostMain = intval($_POST['quantity_posts_main'] ?? 5);
        $mailingList = isset($_POST['mailing_list']) ? 1 : 0;

        if ($quantityPostMain > 0 && $quantityPostMain < 100) {
            Config::getInstance()->set('cms', 'quantity_posts_main', $quantityPostMain);
        }

        if (mb_strlen($siteName) > 1) {
            Config::getInstance()->set('cms', 'site_name', $siteName);
        }

        Config::getInstance()->set('cms', 'mailing_list', $mailingList);

        Config::getInstance()->save('cms');
    }
}
