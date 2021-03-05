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

    private function __clone() {}
    private function __wakeup() {}

}
