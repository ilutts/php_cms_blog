<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

ini_set('session.gc_maxlifetime', 60 * 60 * 2);
ini_set('session.cookie_lifetime', 60 * 60 * 2);

session_start();

if (isset($_GET['exit'])) {
    unset($_SESSION['isAuth']);

    setcookie(session_name(), session_id(), time() - 60 * 60 * 24, '/');

    session_destroy();

    header('Location: /');
    die();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php');

use \App\Router;
use \App\Application;
use App\Controller\AccountController;
use App\Controller\PostController;

$router = new Router();

$router->get('/', PostController::class . '@mainView');
$router->get('/post/*', PostController::class . '@postView');

$router->get('/login', AccountController::class . '@loginView');
$router->get('/registration', AccountController::class . '@registrationView');
$router->get('/profile', AccountController::class . '@profileView');

$application = new Application($router);

$application->run();
