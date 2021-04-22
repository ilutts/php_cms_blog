<?php

namespace App\Service;

use App\Config;

class ConfigsService
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

    public static function set(string $siteName, int $quantityPostMain, bool $mailingList)
    {
        $siteName = htmlspecialchars($siteName);

        if ($quantityPostMain > 0 && $quantityPostMain < 100) {
            Config::getInstance()->set('cms', 'quantity_posts_main', $quantityPostMain);
        }

        if (mb_strlen($siteName) > 1) {
            Config::getInstance()->set('cms', 'site_name', $siteName);
        }

        Config::getInstance()->set('cms', 'mailing_list', (int)$mailingList);

        Config::getInstance()->save('cms');
    }
}
