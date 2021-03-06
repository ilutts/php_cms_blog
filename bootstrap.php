<?php

define('APP_DIR', '/src/');
define('VIEW_DIR', '/view/');
define('CONFIGS_DIR', '/configs/');
define('UPLOAD_USER_DIR', '/img/user/');
define('UPLOAD_POST_DIR', '/img/post/');

// Пользователи
define('ADMIN_ID', 1);

// Группа пользователей
define('ADMIN_GROUP', 1);
define('CONTENT_MANAGER_GROUP', 2);
define('REGISTERED_USER_GROUP', 3);

require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
