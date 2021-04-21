<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $data['title'] ?></title>
    <link rel="stylesheet" href="/css/normolize.css" />
    <link rel="stylesheet" href="/css/styles.css" />
    <script src="/js/script.js" defer></script>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header__top">
                <a href="/" class="logo link">
                    <h1 class="title"><?= $data['title'] ?></h1>
                </a>

                <?php if (empty($_SESSION['isAuth'])) { ?>
                    <a href="/login" class="header__link link">Авторизация</a>
                <?php } else { ?>
                    <a href="/profile" class="header__link link"><?= $_SESSION['user']['name'] ?></a>
                    <?php if (isset($_SESSION['roles']['1']) || isset($_SESSION['roles']['2'])) : ?>
                        <a href="/admin" class="link link--admin">Админ-панель</a>
                    <?php endif ?>
                    <a href="/?exit" class="link">Выйти</a>
                <?php } ?>

            </div>
            <div class="header__bottom">
                <nav class="nav">
                    <ul class="nav__list">
                        <?php foreach ($data['menu'] as $menu) : ?>
                            <li class="nav__item">
                                <a href="<?= $menu->url ?>" class="nav__link"><?= $menu->title ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </nav>
            </div>
    </header>