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

use App\Router;
use App\Application;
use App\Controller\AccountController;
use App\Controller\AdminController;
use App\Controller\PostController;
use App\Controller\SetupController;
use App\Controller\StaticPageController;

$router = new Router();

$router->get('/', PostController::class . '@mainView');
$router->get('/post/*', PostController::class . '@postView');

$router->get('/page/*', StaticPageController::class . '@pageView');

$router->get('/login', AccountController::class . '@loginView');
$router->get('/registration', AccountController::class . '@registrationView');
$router->get('/profile', AccountController::class . '@profileView');
$router->get('/unsubscribe/*/*', AccountController::class . '@unsubscribeView');

$router->get('/admin', AdminController::class . '@mainView');
$router->get('/admin/users', AdminController::class . '@usersView');
$router->get('/admin/signeds', AdminController::class . '@signedsView');
$router->get('/admin/comments', AdminController::class . '@commentsView');
$router->get('/admin/statics', AdminController::class . '@staticsView');
$router->get('/admin/settings', AdminController::class . '@settingsView');

$router->get('/setup', SetupController::class . '@installDB');

$router->get('/ajax/post/get', PostController::class . '@ajaxGetPost', 'post');
$router->get('/ajax/user/get', AccountController::class . '@ajaxGetUser', 'post');
$router->get('/ajax/page/get', StaticPageController::class . '@ajaxGetPage', 'post');

$application = new Application($router);

$application->run();
