<?php

namespace App;

class Route
{
    private string $method;
    private string $path;
    private $callback;

    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    private function prepareCallback($callback)
    {
        if (is_callable($callback)) {
            return $callback;
        }

        if (is_string($callback)) {
            // Получаем класс контроллера и название метода
            $callback = explode('@', $callback);

            if (count($callback) === 2) {
                return [new $callback[0](), $callback[1]];
            }
        }

        throw new \Exception('Неверно указана функция Callback!', 500);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function match($method, $uri): bool
    {
        if (
            strtolower($method) === $this->method &&
            (parse_url($uri, PHP_URL_PATH) === $this->path ||
                preg_match('/^' . str_replace(['*', '/'], ['\w+', '\/'], $this->getPath()) . '$/', $uri))
        ) {
            return true;
        }

        return false;
    }

    public function run($uri)
    {
        // Определяем наличие параметров в URL
        $paramUri = array_diff(explode('/', $uri), explode('/', $this->getPath()));

        return call_user_func_array($this->prepareCallback($this->callback), $paramUri);
    }
}
