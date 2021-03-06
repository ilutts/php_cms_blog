<?php

namespace App\Exception;

use App\Config;
use App\Model\AdminMenu;
use App\Model\Menu;

class HttpException extends \Exception
{
    protected function getInfoForHeader()
    {
        return [
            'title' => Config::getInstance()->get('cms.site_name'),
            'menu' => Menu::all()
        ];
    }

    protected function getInfoForAdminHeader()
    {
        return [
            'title' => Config::getInstance()->get('cms.site_name'),
            'menu' => AdminMenu::all()
        ];
    }

    protected function getInfoForFooter()
    {
        return [
            'title' => Config::getInstance()->get('cms.site_name'),
        ];
    }
}
