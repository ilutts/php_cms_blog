<?php

namespace App\Service;

use App\Model\CommentRepository;
use App\Model\RoleRepository;
use App\Model\MenuRepository;
use App\Model\PostRepository;
use App\Model\RoleUserRepository;
use App\Model\UserRepository;

class SetupServices
{
    public static function installDB()
    {
        self::addPost();
        self::addMenu();
        self::addUser();
        self::addGroup();
        self::addComment();
        self::addLinkRoleUser();
    }

    private static function addPost()
    {
        PostRepository::createTable();
        PostRepository::add('Test', 'Test1', 'Test2');
        PostRepository::add('Test2', 'Test2', 'Test3');
    }

    private static function addMenu()
    {
        MenuRepository::createTable();
        MenuRepository::add('main', 'Главная', '/');
        MenuRepository::add('blog', 'Блог', '/blog');
    }

    private static function addUser()
    {
        UserRepository::createTable();
        UserRepository::add('test@test.ru', '123', 'TEST');
        UserRepository::add('admin@admin.ri', '123', 'Admin');
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
        CommentRepository::add('Привет', 'Как дела?', 1, 1);
        CommentRepository::add('Привет1', 'Как дела?1', 1, 1);
        CommentRepository::add('Привет2', 'Как дела?2', 0, 0);
    }

    private static function addLinkRoleUser()
    {
        RoleUserRepository::createTable();
        RoleUserRepository::add(2, 1);
        RoleUserRepository::add(1, 2);
    }
}