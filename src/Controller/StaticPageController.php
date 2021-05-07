<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\StaticPage;
use App\View\View;

class StaticPageController extends Controller
{
    public function staticPage(string $namePage)
    {
        $staticPage = StaticPage::where('name', $namePage)->first();

        if (!$staticPage) {
            throw new NotFoundException('Страница не найдена!');
        }

        return new View('static', [
            'header' => $this->getInfoForHeader(),
            'main' => $staticPage,
            'footer' => $this->getInfoForFooter(),
        ]);
    }
}
