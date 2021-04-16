<?php require($_SERVER['DOCUMENT_ROOT'] . '/view/templates/base/header.php'); ?>

<header class="header">
  <div class="container">
    <div class="header__top">
        <a href="/" class="logo link">
            <h1 class="title">CMS - Блог</h1>
        </a>
        
        <?php if (empty($_SESSION['isAuth'])) { ?>
          <a href="/login" class="header__link link">Авторизация</a>
        <?php } else { ?>
          <a href="/profile" class="header__link link"><?= $_SESSION['user']['name'] ?></a>
          <?php if (isset($_SESSION['roles']['1']) || isset($_SESSION['roles']['2'])): ?>
            <a href="/admin" class="link link--admin">Админ-панель</a>
          <?php endif ?>
          <a href="/?exit" class="link">Выйти</a>
        <?php } ?> 

    </div>
    <div class="header__bottom">
      <nav class="nav">
        <ul class="nav__list">
          <?php foreach ($data as $id => $menu): ?>
            <li class="nav__item">
              <a href="<?= $menu->url ?>" class="nav__link"><?= $menu->title ?></a>
            </li>
          <?php endforeach ?>
        </ul>
      </nav>
    </div>
</header>
