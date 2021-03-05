<?php require($_SERVER['DOCUMENT_ROOT'] . '/view/templates/base/header.php'); ?>

<header class="header">
  <div class="container">
    <div class="header__top">
        <a href="#" class="logo link">
            <h1 class="title">CMS - Блог</h1>
        </a>
        <a href="tel:+74953225448" class="header__phone">+7 495 322 54 48</a>
        <a href="#" class="header__link link">Личный кабинет</a>
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
      <form class="search">
        <input class="search__input" type="text" placeholder="Поиск" />
        <input class="search__submit" type="submit" value="" />
      </form>
    </div>
</header>
