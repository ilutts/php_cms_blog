-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.19 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп структуры для таблица cms_db.admin_menu
CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_menu_title_unique` (`title`),
  UNIQUE KEY `admin_menu_url_unique` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.admin_menu: ~6 rows (приблизительно)
DELETE FROM `admin_menu`;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` (`id`, `title`, `url`, `created_at`, `updated_at`) VALUES
	(1, 'Статьи', '/admin', '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(2, 'Пользователи', '/admin/users', '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(3, 'Подписки', '/admin/signeds', '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(4, 'Комментарии', '/admin/comments', '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(5, 'Статичные страницы', '/admin/statics', '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(6, 'Настройки CMS', '/admin/settings', '2021-04-21 21:13:14', '2021-04-21 21:13:14');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;

-- Дамп структуры для таблица cms_db.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_foreign` (`post_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.comments: ~4 rows (приблизительно)
DELETE FROM `comments`;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `text`, `post_id`, `user_id`, `approved`, `created_at`, `updated_at`) VALUES
	(1, 'Как дела?', 1, 1, 1, '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(2, 'Как дела?1', 1, 1, 1, '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(3, 'Как дела?2', 2, 2, 1, '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(4, 'Как дела?2', 2, 1, 1, '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(5, 'Тест', 2, 3, 0, '2021-04-22 19:14:32', '2021-04-22 19:14:32'),
	(6, 'Тест 1', 3, 1, 1, '2021-04-22 19:17:21', '2021-04-22 19:17:21'),
	(7, 'тест2\r\n', 3, 1, 1, '2021-04-22 19:20:30', '2021-04-22 19:20:30'),
	(8, 'тест 3', 3, 3, 0, '2021-04-22 19:20:53', '2021-04-22 19:20:53'),
	(9, 'павпвап', 3, 1, 1, '2021-04-22 21:45:20', '2021-04-22 21:45:20'),
	(10, 'аорао', 3, 1, 1, '2021-04-22 21:45:23', '2021-04-22 21:45:23'),
	(11, 'смчмчсм', 3, 1, 1, '2021-04-22 21:45:25', '2021-04-22 21:45:25'),
	(12, 'sdfsdf', 3, 1, 1, '2021-04-22 22:53:49', '2021-04-22 22:53:49'),
	(13, 'Привет', 4, 2, 1, '2021-04-23 00:36:06', '2021-04-23 00:36:06');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Дамп структуры для таблица cms_db.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `static_page_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_title_unique` (`title`),
  UNIQUE KEY `menus_url_unique` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.menus: ~3 rows (приблизительно)
DELETE FROM `menus`;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`id`, `title`, `url`, `static_page_id`, `created_at`, `updated_at`) VALUES
	(1, 'Главная', '/', 0, '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(2, 'О нас', '/page/about', 1, '2021-04-21 21:13:15', '2021-04-21 21:13:15'),
	(3, 'Контакты', '/page/contacts', 2, '2021-04-21 21:13:15', '2021-04-21 21:13:15');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Дамп структуры для таблица cms_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.roles: ~3 rows (приблизительно)
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'administrator', 'Полный доступ к админ-панели', '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(2, 'content manager', 'Может изменять/создавать статьи и модерирует комментарии к ним', '2021-04-21 21:13:14', '2021-04-21 21:13:14'),
	(3, 'registered', 'Может оставлять комментарии', '2021-04-21 21:13:14', '2021-04-21 21:13:14');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Дамп структуры для таблица cms_db.role_user
CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int unsigned NOT NULL,
  `role_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `role_user_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.role_user: ~2 rows (приблизительно)
DELETE FROM `role_user`;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2021-04-21 21:13:15', '2021-04-21 21:13:15'),
	(2, 2, '2021-04-21 21:13:15', '2021-04-21 21:13:15'),
	(3, 3, '2021-04-22 19:14:17', '2021-04-22 19:14:17'),
	(4, 3, '2021-04-22 23:13:47', '2021-04-22 23:13:47'),
	(5, 3, '2021-04-22 23:37:51', '2021-04-22 23:37:51');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;

-- Дамп структуры для таблица cms_db.static_pages
CREATE TABLE IF NOT EXISTS `static_pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `static_pages_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.static_pages: ~2 rows (приблизительно)
DELETE FROM `static_pages`;
/*!40000 ALTER TABLE `static_pages` DISABLE KEYS */;
INSERT INTO `static_pages` (`id`, `title`, `body`, `name`, `actived`, `created_at`, `updated_at`) VALUES
	(1, 'О нас', 'Это крутая CMS!', 'about', 1, '2021-04-21 21:13:15', '2021-04-21 21:13:15'),
	(2, 'Контакты', 'admin@admin.ru и телефон 999 999 999', 'contacts', 1, '2021-04-21 21:13:15', '2021-04-21 21:13:15');
/*!40000 ALTER TABLE `static_pages` ENABLE KEYS */;

-- Дамп структуры для таблица cms_db.unregistered_subscribers
CREATE TABLE IF NOT EXISTS `unregistered_subscribers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `signed` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unregistered_subscribers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.unregistered_subscribers: ~2 rows (приблизительно)
DELETE FROM `unregistered_subscribers`;
/*!40000 ALTER TABLE `unregistered_subscribers` DISABLE KEYS */;
INSERT INTO `unregistered_subscribers` (`id`, `email`, `signed`, `created_at`, `updated_at`) VALUES
	(1, '123@123.ru', 1, '2021-04-21 21:13:15', '2021-04-23 00:37:58'),
	(2, '321@312.ru', 1, '2021-04-21 21:13:15', '2021-04-21 21:13:15');
/*!40000 ALTER TABLE `unregistered_subscribers` ENABLE KEYS */;

-- Дамп структуры для таблица cms_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '/img/user/no-avatar.png',
  `signed` tinyint(1) NOT NULL DEFAULT '0',
  `actived` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы cms_db.users: ~2 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `name`, `about`, `image`, `signed`, `actived`, `created_at`, `updated_at`) VALUES
	(1, 'admin@admin.ru', '$2y$10$2cOF4UeI.HIqyvDbiuCe8eNd5NPEfUswns0m5KkzbkBfLcEhOz3sG', 'Admin', NULL, '/img/user/no-avatar.png', 1, 1, '2021-04-21 21:13:14', '2021-04-23 00:37:48'),
	(2, 'test@test.ru', '$2y$10$2cOF4UeI.HIqyvDbiuCe8eNd5NPEfUswns0m5KkzbkBfLcEhOz3sG', 'TEST', NULL, '/img/user/no-avatar.png', 1, 1, '2021-04-21 21:13:14', '2021-04-23 00:35:57'),
	(3, '555@555.ru', '$2y$10$BhSX7gSMzfkqnTcaVpbU/uVC4hQpL6z/Vphmh1CGa2naMGX7cNNR6', 'Ivanovich', NULL, '/img/user/no-avatar.png', 0, 1, '2021-04-22 19:14:17', '2021-04-22 19:14:17'),
	(4, 'as@as.ru1', '$2y$10$crQU.8vxpWg5EHcbdAuH3OqpM2NhWhAJ9TfVIkeOUsNq9viR3bpSC', 'Asas1', '', '/img/user/no-avatar.png', 0, 1, '2021-04-22 23:13:47', '2021-04-22 23:37:06'),
	(5, 'pa@pa.ru', '$2y$10$T/6jPEdq7Yk9ZPlz6XeICuGYE.UqFEgvLIhqEo5szvxObrOYHrTpu', 'pass1', '', '/img/user/no-avatar.png', 0, 1, '2021-04-22 23:37:51', '2021-04-22 23:43:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
