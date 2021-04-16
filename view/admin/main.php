<main class="main">
    <div class="container">
        <h1 class="main__title">Статьи - Админ-панель</h1>
        <div class="main-admin__header">
            <button class="btn btn--transparent btn-new-post">Новая статья</button>
            <form class="main__form" method="GET" action="/">
                <label for="form__select-quantity">Статей на странице:</label>
                <select id="form__select-quantity" name="quantity" class="input">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="200">200</option>
                    <option value="all">Все</option>
                </select>
            </form>
        </div>
        <ul class="main-admin__list list">
            <li class="list-admin__item">
                <div class="list-admin__cell list__cell--bold">Номер</div>
                <div class="list-admin__cell list__cell--bold">Заголовок</div>
                <div class="list-admin__cell list__cell--bold">Дата публикации</div>
                <div class="list-admin__cell list__cell--bold">Дата обновления</div>
                <div class="list-admin__cell list__cell--bold">Автор</div>
                <div class="list-admin__cell list__cell--bold">Статус</div>
            </li>
            <?php foreach ($data as $post) : ?>
                <li class="list-admin__item">
                    <div class="list-admin__cell list__cell--id"><?= $post->id ?></div>
                    <div class="list-admin__cell list__cell--title"><?= $post->title ?></div>
                    <div class="list-admin__cell list__cell--created-at"><?= $post->created_at ?></div>
                    <div class="list-admin__cell list__cell--ending-at"><?= $post->updated_at ?></div>
                    <div class="list-admin__cell list__cell--author"><?= $post->user->name ?></div>
                    <div class="list-admin__cell list__cell--status"><?= $post->actived ? 'Вкл' : 'Выкл' ?></div>
                    <button class="btn btn--transparent btn-post-change">Изменить</button>
                </li>
            <?php endforeach ?>
        </ul>
        <ul class="main__paginator paginator">
            <?php for ($i = 1; $i <= $data->countPages; $i++) : ?>
                <li class="paginator__item">
                    <a class="paginator__link link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>
        </ul>
    </div>
</main>

<div class="popup">
    <form class="popup__form form--admin-post" method="POST" action="/admin" enctype="multipart/form-data">
        <div class="profile-form__box">
            <h3 class="popup__title">Статья - <span class="popup__id"></span></h3>
            <input type="hidden" name="id">
            <label class="label" for="popup-title">Заголовок</label>
            <input id="popup-title" class="input" name="title" type="text" required minlength="3">
            <label class="label" for="popup-description">Короткое описание</label>
            <input type="text" id="popup-short-description" class="input" name="short_description" required minlength="3">
            <label class="label" for="popup-description">Описание</label>
            <textarea id="popup-description" class="input input--textarea" name="description" required minlength="3"></textarea>
        </div>
        <div class="profile-form__box">
            <label class="label" for="checkbox-rule">Изображение:</label>
            <img class="popup__image" src="/img/post/post-no-img.png" alt="Изображение" width="100px">
            <input class="input" type="file" name="image" id="post_image">
            <label class="label" for="post_active">Показывать статью:</label>
            <input type="checkbox" name="post_active" id="post_active">
            <button class="btn btn--solid" type="submit" name="submit_post">Сохранить</button>
        </div>
    </form>
</div>