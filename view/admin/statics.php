<main class="main">
    <div class="container">
        <h1 class="main__title">Статичный страницы - Админ-панель</h1>
        <div class="main-admin__header">
            <button class="btn btn--transparent btn-new">Новая страница</button>
            <?php if (!empty($data['static_pages']->error)) : ?>
                <h2 class="main__message main__message--error">Ошибка отправки формы!</h2>
            <?php endif ?>
            <form class="main__form main__form--admin" method="GET">
                <label for="form__select-quantity">Элементов на странице:</label>
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
            <li class="list-admin__item list-admin__item--statics">
                <div class="list-admin__cell list-admin__cell--bold">ID</div>
                <div class="list-admin__cell list-admin__cell--bold">Заголовок</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата публикации</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата обновления</div>
                <div class="list-admin__cell list-admin__cell--bold">Главное меню</div>
            </li>
            <?php foreach ($data['static_pages'] as $page) : ?>
                <li class="list-admin__item list-admin__item--statics">
                    <div class="list-admin__cell list-admin__cell--id"><?= $page->id ?></div>
                    <div class="list-admin__cell list-admin__cell--title">
                        <a class="link" href="/page/<?= $page->name ?>"><?= $page->title ?></a>
                    </div>
                    <div class="list-admin__cell list-admin__cell--created-at"><?= $page->created_at ?></div>
                    <div class="list-admin__cell list-admin__cell--ending-at"><?= $page->updated_at ?></div>
                    <div class="list-admin__cell list-admin__cell--status"><?= $page->actived ? 'Да' : 'Нет' ?></div>
                    <div class="list-admin__cell">
                        <button class="btn btn--transparent btn-post-change">Изменить</button>
                        <form method="POST" action="/admin/statics/delete">
                            <button type="submit" class="btn btn--transparent btn-post-delete" name="delete_page" value="<?= $page->id ?>">Удалить</button>
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
    <form class="popup__form form--admin-static" method="POST" action="/admin/statics" enctype="multipart/form-data">
        <div class="profile-form__box">
            <h3 class="popup__title">Страница - <span class="popup__id"></span></h3>
            <input type="hidden" name="id">
            <label class="label" for="popup-name">Название для ссылки (латиница) *</label>
            <input id="popup-name" class="input" name="name" type="text" required minlength="3">
            <label class="label" for="popup-title">Заголовок *</label>
            <input id="popup-title" class="input" name="title" type="text" required minlength="3">
            <label class="label" for="popup-body">Основное</label>
            <textarea id="popup-body" class="input input--textarea" name="body"></textarea>
            <label class="label label--admin-static" for="post_actived">Показывать в меню: <input type="checkbox" name="post_actived" id="post_actived"></label>
            <button class="btn btn--solid" type="submit" name="submit_post">Сохранить</button>
        </div>
        <button type="button" class="popup__close" aria-label="Закрыть"></button>
    </form>
</div>