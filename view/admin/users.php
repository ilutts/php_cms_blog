<main class="main">
    <div class="container">
        <h1 class="main__title">Пользователи - Админ-панель</h1>
        <div class="main-admin__header">
            <form class="main__form main__form--admin" method="GET">
                <label for="form__select-quantity">Пользователей на странице:</label>
                <select id="form__select-quantity" name="quantity" class="input">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="50">50</option>
                    <option value="200">200</option>
                    <option value="all">Все</option>
                </select>
            </form>
        </div>
        <ul class="main-admin__list list">
            <li class="list-admin__item">
                <div class="list-admin__cell list-admin__cell--bold">Номер</div>
                <div class="list-admin__cell list-admin__cell--bold">Email</div>
                <div class="list-admin__cell list-admin__cell--bold">Имя</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата регистрации</div>
                <div class="list-admin__cell list-admin__cell--bold">Роли</div>
                <div class="list-admin__cell list-admin__cell--bold">Статус</div>
            </li>
            <?php foreach ($data as $user) : ?>
                <li class="list-admin__item">
                    <div class="list-admin__cell list-admin__cell--id"><?= $user->id ?></div>
                    <div class="list-admin__cell list-admin__cell--email"><?= $user->email ?></div>
                    <div class="list-admin__cell list-admin__cell--name"><?= $user->name ?></div>
                    <div class="list-admin__cell list-admin__cell--created-at"><?= $user->created_at ?></div>
                    <div class="list-admin__cell list-admin__cell--roles">
                        <?php foreach ($user->roles as $role) : ?>
                            <?= $role->name . ' ' ?>
                        <?php endforeach ?>
                    </div>
                    <div class="list-admin__cell list__cell--status"><?= $user->actived ? 'Вкл' : 'Выкл' ?></div>
                    <button class="btn btn--transparent btn-post-change">Изменить</button>
                </li>
            <?php endforeach ?>
        </ul>
        <ul class="main__paginator paginator">
            <?php for ($i = 1; $i <= $data->countPages; $i++) : ?>
                <li class="paginator__item">
                    <a class="paginator__link" <?= getStatusPage($i) ?>><?= $i ?></a>
                </li>
            <?php endfor ?>
        </ul>
    </div>
</main>

<div class="popup">
    <form class="popup__form form--admin-user" method="POST" action="/admin/users" enctype="multipart/form-data">
        <div class="profile-form__box">
            <h3 class="popup__title">Пользователь - <span class="popup__id"></span></h3>
            <input type="hidden" name="id">
            <label class="label" for="popup-email">Email - Логин</label>
            <input id="popup-title" class="input" name="email" type="text">
            <label class="label" for="popup-name">Имя</label>
            <input type="text" id="popup-name" class="input" name="name">
            <label class="label" for="popup-description">О себе</label>
            <textarea id="popup-about" class="input input--textarea" name="about"></textarea>
        </div>
        <div class="profile-form__box">
            <label class="label" for="checkbox-rule">Фото:</label>
            <img class="popup__image" src="" alt="Изображение" width="100px">
            <input class="input" type="file" name="image" id="popup_image">
            <label class="label" for="roles">Роли:</label>
            <select name="roles[]" class="input" multiple="multiple" id="roles"></select>
            <label class="label" for="user_actived">Активирован: <input type="checkbox" name="user_actived" id="user_actived"></label>
            <button class="btn btn--solid" type="submit" name="submit_user">Сохранить</button>
        </div>
    </form>
</div>