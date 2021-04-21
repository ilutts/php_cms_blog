<?php

namespace App\Exception;

use App\Model\Menu;
use App\View\Renderable;

class NoAccessException extends HttpException implements Renderable
{
    public function render()
    {
        $file = 'admin/noaccess.php';
        
        $data = [
            'header' => $this->getInfoForAdminHeader(),
            'error' => $this->getMessage(),
            'footer' => $this->getInfoForFooter()
        ];

        includeView('templates/header.php', $data['header']);

        includeView($file, $data['error']);

        includeView('templates/footer.php', $data['footer']);
    }
}
