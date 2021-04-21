<?php

namespace App\Controller;

use App\Model\StaticPage;
use App\View\JsonView;
use App\View\View;

class StaticPageController extends Controller
{
    public function pageView(string $namePage)
    {
        $data = StaticPage::where('name', $namePage)->first();

        return new View('static', [
            'header' => $this->getInfoForHeader(),
            'main' => $data,
            'footer' => $this->getInfoForFooter(),
        ]);
    }

    public function ajaxGetPage()
    {
        $id = intval($_POST['id'] ?? 0);
        
        if ($id) {
            $page = StaticPage::findOrFail($id);

            return new JsonView($page);
        }
    }
}