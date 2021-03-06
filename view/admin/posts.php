<main class="main">
    <div class="container">
        <h1 class="main__title">Статьи - Админ-панель</h1>
        <div class="main-admin__header">
            <button class="btn btn--transparent btn-new">Новая статья</button>
            <?php if (!empty($data['posts']->error)) : ?>
                <h2 class="main__message main__message--error">Ошибка отправки формы!</h2>
            <?php endif ?>
            <form class="main__form main__form--admin" method="GET">
                <label for="form__select-quantity">Статей на странице:</label>
                <select id="form__select-quantity" name="quantity" class="input input--main-admin">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="50">50</option>
                    <option value="200">200</option>
                    <option value="all">Все</option>
                </select>
            </form>
        </div>
        <ul class="main-admin__list main-admin__list--posts list">
            <li class="list-admin__item list-admin__item--main">
                <div class="list-admin__cell list-admin__cell--bold">Номер</div>
                <div class="list-admin__cell list-admin__cell--bold">Заголовок</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата публикации</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата обновления</div>
                <div class="list-admin__cell list-admin__cell--bold">Автор</div>
                <div class="list-admin__cell list-admin__cell--bold">Статус</div>
            </li>
            <?php foreach ($data['posts'] as $post) : ?>
                <li class="list-admin__item list-admin__item--main">
                    <div class="list-admin__cell list-admin__cell--id"><?= $post->id ?></div>
                    <div class="list-admin__cell list-admin__cell--title"><?= $post->title ?></div>
                    <div class="list-admin__cell list-admin__cell--created-at"><?= $post->created_at ?></div>
                    <div class="list-admin__cell list-admin__cell--ending-at"><?= $post->updated_at ?></div>
                    <div class="list-admin__cell list-admin__cell--author"><?= $post->user->name ?></div>
                    <div class="list-admin__cell list-admin__cell--status"><?= $post->actived ? 'Вкл' : 'Выкл' ?></div>
                    <div class="list-admin__cell">
                        <button class="btn btn--transparent btn-post-change">Изменить</button>
                        <form method="POST" action="/admin/post/delete">
                            <button type="submit" class="btn btn--transparent btn-post-delete" name="delete_post" value="<?= $post->id ?>">Удалить</button>
                        </form>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
        <ul class="main__paginator paginator">
            <?php for ($i = 1; $i <= $data['count_pages']; $i++) : ?>
                <li class="paginator__item">
                    <a class="paginator__link" <?= getStatusPage($i) ?>><?= $i ?></a>
                </li>
            <?php endfor ?>
        </ul>
    </div>
</main>

<div class="popup">
    <form class="popup__form form--admin-post" method="POST" enctype="multipart/form-data">
        <div class="profile-form__box">
            <h3 class="popup__title">Статья - <span class="popup__id"></span></h3>
            <input type="hidden" name="id">
            <label class="label" for="popup-title">Заголовок *</label>
            <input id="popup-title" class="input" name="title" type="text" required minlength="1">
            <label class="label" for="popup-description">Короткое описание *</label>
            <input type="text" id="popup-short-description" class="input" name="short_description" required minlength="3">
            <label class="label" for="popup-description">Описание *</label>
            <textarea id="popup-description" class="input input--textarea" name="description" required minlength="3"></textarea>
        </div>
        <div class="profile-form__box">
            <label class="label" for="checkbox-rule">Изображение:</label>
            <img class="popup__image" src="" alt="Изображение" accept=".jpg, .jpeg, .png">
            <input class="input" type="file" name="image" id="popup_image">
            <label class="label" for="post_actived">Показывать статью: <input type="checkbox" name="post_actived" id="post_actived"></label>
            <button class="btn btn--solid" type="submit" name="submit_post">Сохранить</button>
        </div>
        <button type="button" class="popup__close" aria-label="Закрыть"></button>
    </form>
</div>