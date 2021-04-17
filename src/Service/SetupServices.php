<?php

namespace App\Service;

use App\Model\CommentRepository;
use App\Model\AdminMenuRepository;
use App\Model\RoleRepository;
use App\Model\MenuRepository;
use App\Model\PostRepository;
use App\Model\RoleUserRepository;
use App\Model\UserRepository;

class SetupServices
{
    public static function installDB()
    {
        self::addUser();
        self::addPost();
        self::addMenu();
        self::addMenuAdmin();
        self::addGroup();
        self::addComment();
        self::addLinkRoleUser();
    }

    private static function addPost()
    {
        PostRepository::createTable();
        PostRepository::add('Test', 'Test1', 'Test2', 1, true);
        PostRepository::add('Test2', 'Test2', 'Test3', 2, true);
    }

    private static function addMenu()
    {
        MenuRepository::createTable();
        MenuRepository::add('main', 'Главная', '/');
        MenuRepository::add('blog', 'Блог', '/blog');
    }

    private static function addMenuAdmin()
    {
        AdminMenuRepository::createTable();
        AdminMenuRepository::add('posts', 'Статьи', '/admin');
        AdminMenuRepository::add('users', 'Пользователи', '/admin/users');
        AdminMenuRepository::add('signeds', 'Подписки', '/admin/signeds');
        AdminMenuRepository::add('comments', 'Комментарии', '/admin/comments');
        AdminMenuRepository::add('static_page', 'Статичные страницы', '/admin/statics');
        AdminMenuRepository::add('configs', 'Настройки CMS', '/admin/сonfigs');
    }

    private static function addUser()
    {
        UserRepository::createTable();
        UserRepository::add('admin@admin.ru', '$2y$10$2cOF4UeI.HIqyvDbiuCe8eNd5NPEfUswns0m5KkzbkBfLcEhOz3sG', 'Admin');
        UserRepository::add('test@test.ru', '$2y$10$2cOF4UeI.HIqyvDbiuCe8eNd5NPEfUswns0m5KkzbkBfLcEhOz3sG', 'TEST');
    }

    private static function addGroup()
    {
        RoleRepository::createTable();
        RoleRepository::add('administrator', 'Полный доступ к админ-панели');
        RoleRepository::add('content manager', 'Может изменять/создавать статьи и модерирует комментарии к ним');
        RoleRepository::add('registered', 'Может оставлять комментарии');
    }

    private static function addComment()
    {
        CommentRepository::createTable();
        CommentRepository::add('Как дела?', 1, 1, true);
        CommentRepository::add('Как дела?1', 1, 1, true);
        CommentRepository::add('Как дела?2', 2, 2, true);
        CommentRepository::add('Как дела?2', 2, 1, true);
    }

    private static function addLinkRoleUser()
    {
        RoleUserRepository::createTable();
        RoleUserRepository::add(1, 1);
        RoleUserRepository::add(2, 2);
    }
}
