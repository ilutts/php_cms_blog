<?php

namespace App\Controller;

use App\Config;
use App\Model\AdminMenu;
use App\Model\Menu;

abstract class Controller
{
    protected function getInfoForHeader()
    {
        return [
            'title' => Config::getInstance()->get('cms.site_name'),
            'menu' => Menu::all()
        ];
    }

    protected function getInfoForFooter()
    {
        return [
            'title' => Config::getInstance()->get('cms.site_name'),
        ];
    }
}
