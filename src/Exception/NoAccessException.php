<?php

namespace App\Exception;

use App\View\Renderable;

class NoAccessException extends HttpException implements Renderable
{
    public function render()
    {
        $file = 'admin/noaccess.php';

        $data = [
            'header' => $this->getInfoForAdminHeader(),
            'main' => $this->getMessage(),
            'footer' => $this->getInfoForFooter()
        ];

        showTemplate($file, $data);
    }
}
