<?php

namespace App;

final class Config
{
    /** @var Config */
    private static $instance;

    private $configs = [];

    public static function getInstance(): Config
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . CONFIGS_DIR;
        $files = scandir($path);

        foreach ($files as $file) {

            $fullPath = $path . $file;

            if (is_file($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
                $this->configs[pathinfo($fullPath, PATHINFO_FILENAME)] = include($fullPath);
            }
        }
    }

    public function get(string $config, $default = null)
    {
        return array_get($this->configs, $config, $default);
    }

    public function set(string $file, string $config, string $value)
    {
        $this->configs[$file][$config] = $value;
    }

    public function save(string $file)
    {
        $content = "<?php" . PHP_EOL . PHP_EOL . "return " . var_export($this->configs[$file], true) . ';' . PHP_EOL;

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . CONFIGS_DIR . $file . '.php', $content);
    }

    public function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
