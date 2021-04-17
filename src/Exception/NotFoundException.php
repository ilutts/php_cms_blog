<?php

namespace App\Exception;

use App\Model\Menu;
use \App\View\Renderable;

class NotFoundException extends HttpException implements Renderable
{
    public function render()
    {
        $file = '404.php';

        $data = [
            'header' => Menu::all(),
            'error' => $this->getMessage() . ' :-('
        ];

        includeView('templates/header.php', $data['header']);

        includeView($file, $data['error']);

        includeView('templates/footer.php');
    }
}
