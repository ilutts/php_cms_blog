<?php

namespace App\Service;

use App\Model\CommentRepository;
use App\Model\AdminMenuRepository;
use App\Model\RoleRepository;
use App\Model\MenuRepository;
use App\Model\PostRepository;
use App\Model\RoleUserRepository;
use App\Model\StaticPageRepository;
use App\Model\UnregisteredSubscriberRepository;
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
        self::addUnregisteredSubscriber();
        self::addStaticPages();
    }

    private static function addPost()
    {
        PostRepository::createTable();
        PostRepository::add('Test', 'Test1', 'Test2', 1, true);
        PostRepository::add('Test2', 'Test2', 'Test3', 2, true);
        PostRepository::add('Статья - 1', 'Это тестовая статья и всяком разном', 'Иногда - бывает так, что там где не ждали, проиходит то - чего хотели', 1, true);
    }

    private static function addMenu()
    {
        MenuRepository::createTable();
        MenuRepository::add('Главная', '/', 0);
    }

    private static function addMenuAdmin()
    {
        AdminMenuRepository::createTable();
        AdminMenuRepository::add('Статьи', '/admin');
        AdminMenuRepository::add('Пользователи', '/admin/users');
        AdminMenuRepository::add('Подписки', '/admin/signeds');
        AdminMenuRepository::add('Комментарии', '/admin/comments');
        AdminMenuRepository::add('Статичные страницы', '/admin/statics');
        AdminMenuRepository::add('Настройки CMS', '/admin/settings');
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

    private static function addUnregisteredSubscriber()
    {
        UnregisteredSubscriberRepository::createTable();
        UnregisteredSubscriberRepository::add('123@123.ru');
        UnregisteredSubscriberRepository::add('321@312.ru');
    }

    private static function addStaticPages()
    {
        StaticPageRepository::createTable();
        StaticPageRepository::add('О нас', 'Это крутая CMS!', 'about', true);
        MenuRepository::add('О нас', '/page/about', 1);
        StaticPageRepository::add('Контакты', 'admin@admin.ru и телефон 999 999 999', 'contacts', true);
        MenuRepository::add('Контакты', '/page/contacts', 2);
    }
}
