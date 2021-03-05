<?php

namespace App;

use App\Service\SetupServices;
use App\View\Renderable;
use \Illuminate\Database\Capsule\Manager as Capsule;

class Application
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->initialize();
        $this->router = $router;
    }

    private function renderException(\Exception $e) 
    {
        if ($e instanceof Renderable) {
           return $e->render();
        }

        $codeException =  $e->getCode();

        if ($e->getCode() === 0) {
            $codeException = 500;
        }

        echo 'Ошибка! - ' . $e->getMessage() . ' Код ошибка - ' . $codeException;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        try {
            $dispatch = $this->router->dispatch($method, $uri);
            
            if ($dispatch instanceof Renderable) {
                $dispatch->render();
            } else {
                echo $dispatch;
            }
        } catch(\Exception $e) {
            $this->renderException($e);
        }
    }

    private function initialize()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => Config::getInstance()->get('db.host'),
            'database'  => Config::getInstance()->get('db.database'),
            'username'  => Config::getInstance()->get('db.user'),
            'password'  => Config::getInstance()->get('db.password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        SetupServices::installDB();
    }
}