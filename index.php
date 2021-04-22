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
use App\Controller\Admin\AdminCommentController;
use App\Controller\Admin\AdminPostController;
use App\Controller\Admin\AdminSettingController;
use App\Controller\Admin\AdminStaticPageController;
use App\Controller\Admin\AdminUserController;
use App\Controller\PostController;
use App\Controller\SetupController;
use App\Controller\StaticPageController;

$router = new Router();

$router->get('/', PostController::class . '@postsView');
$router->get('/post/*', PostController::class . '@postView');

$router->get('/page/*', StaticPageController::class . '@pageView');

$router->get('/login', AccountController::class . '@loginView');
$router->get('/registration', AccountController::class . '@registrationView');
$router->get('/profile', AccountController::class . '@profileView');
$router->get('/unsubscribe/*/*', AccountController::class . '@unsubscribeView');

$router->get('/admin', AdminPostController::class . '@postsView');
$router->get('/admin/users', AdminUserController::class . '@usersView');
$router->get('/admin/signeds', AdminUserController::class . '@signedsView');
$router->get('/admin/comments', AdminCommentController::class . '@commentsView');
$router->get('/admin/statics', AdminStaticPageController::class . '@staticPagesView');
$router->get('/admin/settings', AdminSettingController::class . '@settingsView');

$router->get('/setup', SetupController::class . '@installDB');

$router->get('/ajax/post/get', AdminPostController::class . '@ajaxGetPost', 'post');
$router->get('/ajax/user/get', AdminUserController::class . '@ajaxGetUser', 'post');
$router->get('/ajax/static/get', AdminStaticPageController::class . '@ajaxGetStaticPage', 'post');

$application = new Application($router);

$application->run();
