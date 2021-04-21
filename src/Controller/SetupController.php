<?php

namespace App\Controller;

use App\Service\SetupServices;
use App\View\View;

class SetupController extends Controller
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
            'header' => $this->getInfoForHeader(),
            'main' => $text,
            'footer' => $this->getInfoForFooter(),
        ]);
    }
}
