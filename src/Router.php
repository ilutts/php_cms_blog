<?php

namespace App;

use \App\Exception\NotFoundException;

class Router
{
    private array $routes;

    public function get(string $path, $action, string $method = 'all')
    {
        // Задание однотипного формата
        $path = '/' . implode('/', explode('/', trim($path, '/')));

        $this->routes[$path] = new Route($method, $path, $action);
    }

    public function dispatch(string $method, string $uri)
    {
        foreach ($this->routes as $route) {
            if ($route->match($method, $uri)) {
                return $route->run($uri);
            }
        }

        throw new NotFoundException('Страница не найдена', 500);
    }
}
