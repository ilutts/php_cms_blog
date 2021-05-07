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

$router->get('/', PostController::class . '@posts');
$router->get('/post/*', PostController::class . '@post');

$router->get('/page/*', StaticPageController::class . '@staticPage');

$router->get('/login', AccountController::class . '@login', 'get');
$router->get('/login/auth', AccountController::class . '@authorization', 'post');
$router->get('/registration', AccountController::class . '@registration');
$router->get('/profile', AccountController::class . '@profile');
$router->get('/unsubscribe/*/*', AccountController::class . '@unsubscribe');

$router->get('/admin', AdminPostController::class . '@posts', 'get');
$router->get('/ajax/post/get', AdminPostController::class . '@ajaxGetPost', 'post');
$router->get('/admin/post/add', AdminPostController::class . '@addPost', 'post');
$router->get('/admin/post/update', AdminPostController::class . '@updatePost', 'post');
$router->get('/admin/post/delete', AdminPostController::class . '@deletePost', 'post');

$router->get('/admin/users', AdminUserController::class . '@users', 'get');
$router->get('/ajax/user/get', AdminUserController::class . '@ajaxGetUser', 'post');
$router->get('/admin/users/update', AdminUserController::class . '@updateUser', 'post');
$router->get('/admin/users/delete', AdminUserController::class . '@deleteUser', 'post');

$router->get('/admin/signeds', AdminUserController::class . '@signeds', 'get');
$router->get('/admin/signeds/update-reguser', AdminUserController::class . '@updateSignedRegUser', 'post');
$router->get('/admin/signeds/update-unreguser', AdminUserController::class . '@updateSignedUnregUser', 'post');
$router->get('/admin/signeds/delete-unreguser', AdminUserController::class . '@deleteUnregisteredSubscriber', 'post');

$router->get('/admin/comments', AdminCommentController::class . '@comments', 'get');
$router->get('/admin/comment/approved', AdminCommentController::class . '@approvedComment', 'post');
$router->get('/admin/comment/delete', AdminCommentController::class . '@deleteComment', 'post');

$router->get('/admin/statics', AdminStaticPageController::class . '@staticPages', 'get');
$router->get('/ajax/static/get', AdminStaticPageController::class . '@ajaxGetStaticPage', 'post');
$router->get('/admin/statics/add', AdminStaticPageController::class . '@addStaticPage', 'post');
$router->get('/admin/statics/update', AdminStaticPageController::class . '@updateStaticPage', 'post');
$router->get('/admin/statics/delete', AdminStaticPageController::class . '@deleteStaticPage', 'post');

$router->get('/admin/settings', AdminSettingController::class . '@settings', 'get');
$router->get('/admin/settings/save', AdminSettingController::class . '@save', 'post');

$router->get('/setup', SetupController::class . '@installDB');

$application = new Application($router);

$application->run();
