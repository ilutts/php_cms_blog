<?php

namespace App\Exception;

use App\View\Renderable;

class NotFoundException extends HttpException implements Renderable
{
    public function render()
    {
        $file = '404.php';

        $data = [
            'header' => $this->getInfoForHeader(),
            'main' => $this->getMessage() . ' :-(',
            'footer' => $this->getInfoForFooter()
        ];

        showTemplate($file, $data);
    }
}
