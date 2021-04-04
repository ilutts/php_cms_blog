<?php

namespace App\Controller;

use App\Model\Menu;
use App\Service\SetupServices;
use App\View\View;

class SetupController
{
    public function installDB()
    {
        $text = 'Успешная начальная настройка БД!';

        try {
            SetupServices::installDB();
        } catch (\Exception $e) {
            $text = 'Ошибка начальной настройки БД! - ' . $e->getMessage();
        }

        return new View('setup', [
            'header' => Menu::all(), 
            'main' => $text,
            'footer' => [], 
        ]);
    }
}