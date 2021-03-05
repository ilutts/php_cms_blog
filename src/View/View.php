<?php

namespace App\View;

class View implements Renderable
{
    private string $page;
    private array $data;

    public function __construct(string $page, array $data)
    {
        $this->page = $page;
        $this->data = $data;
    }

    public function render()
    {
        $path = explode('.', $this->page);

        if (count($path) === 0) {
            return false;
        }

        $path[count($path) - 1] = $path[count($path) - 1] . '.php';
        $file = implode('/', $path);

        includeView('templates/header.php', $this->data['header']);

        includeView($file, $this->data['main']);

        includeView('templates/footer.php', $this->data['footer']);
    }
}
