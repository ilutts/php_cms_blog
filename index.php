<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

ini_set('session.gc_maxlifetime', 60 * 20);
ini_set('session.cookie_lifetime', 60 * 20);

session_start();

if (isset($_GET['exit'])) {
    unset($_SESSION['isAuth']);

    setcookie(session_name(), session_id(), time() - 60 * 60 * 24, '/');

    session_destroy();

    header('Location: /');
    die();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php');

use \App\View\View;
use \App\Router;
use \App\Application;
use App\Controller\Controller;

$router = new Router();

$router->get('/', Controller::class . '@mainView');

$router->get('/login', Controller::class . '@loginView');

$router->get('/registration', Controller::class . '@registrationView');

$router->get('about', function () {
    return new View('index', ['title' => 'Shop / Contact Page']);
}, 'post');

$router->get('/post/*', Controller::class . '@postView');

$application = new Application($router);

$application->run();
