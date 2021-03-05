<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php');

use \App\View\View;
use \App\Router;
use \App\Application;
use App\Controller\Controller;

$router = new Router();

$router->get('/', Controller::class . '@mainView');

$router->get('about', function () {
    return new View('index', ['title' => 'Shop / Contact Page']);
}, 'post');

$router->get('/test', 'testCallback', 'get');

$router->get('/post/*', Controller::class . '@postView');

/*$router->get('/post/*', function ($id) {
    return "Test page with param1=$id";
});*/

$router->get('/test1', Controller::class . '@index');

$application = new Application($router);

$application->run();
