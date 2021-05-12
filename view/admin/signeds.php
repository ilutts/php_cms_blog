<main class="main">
    <div class="container">
        <h1 class="main__title">Подписки - Админ-панель</h1>
        <div class="main-admin__header">
            <form class="main__form main__form--admin" method="GET">
                <label for="form__select-quantity">Пользователей на странице:</label>
                <select id="form__select-quantity" name="quantity" class="input input--main-admin">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="50">50</option>
                    <option value="200">200</option>
                    <option value="all">Все</option>
                </select>
            </form>
        </div>
        <h2>Зарегистрированные пользователи:</h2>
        <ul class="main-admin__list list">
            <li class="list-admin__item list-admin__item--signed">
                <div class="list-admin__cell list-admin__cell--bold">ID</div>
                <div class="list-admin__cell list-admin__cell--bold">Email</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата регистрации</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата обновления</div>
                <div class="list-admin__cell list-admin__cell--bold">Статус подписки</div>
            </li>
            <?php foreach ($data['registered_users'] as $user) : ?>
                <li class="list-admin__item list-admin__item--signed">
                    <div class="list-admin__cell list-admin__cell--id"><?= $user->id ?></div>
                    <div class="list-admin__cell list-admin__cell--email"><?= $user->email ?></div>
                    <div class="list-admin__cell list-admin__cell--created-at"><?= $user->created_at ?></div>
                    <div class="list-admin__cell list-admin__cell--updated-at"><?= $user->updated_at ?></div>
                    <form class="list-admin__form" method="POST" action="/admin/signeds/update-reguser">
                        <input type="hidden" name="signed" value="<?= $user->signed ?>">
                        <button type="submit" name="reg_user" class="btn <?= $user->signed ? 'btn--solid' : 'btn--transparent' ?>" value="<?= $user->id ?>">
                            <?= $user->signed ? 'Вкл' : 'Выкл' ?>
                        </button>
                    </form>
                </li>
            <?php endforeach ?>
        </ul>

        <h2>Незарегистрированные пользователи:</h2>
        <ul class="main-admin__list list">
            <li class="list-admin__item list-admin__item--signed">
                <div class="list-admin__cell list-admin__cell--bold">ID</div>
                <div class="list-admin__cell list-admin__cell--bold">Email</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата регистрации</div>
                <div class="list-admin__cell list-admin__cell--bold">Дата обновления</div>
                <div class="list-admin__cell list-admin__cell--bold">Статус подписки</div>
            </li>
            <?php foreach ($data['unregistered_users'] as $user) : ?>
                <li class="list-admin__item list-admin__item--signed">
                    <div class="list-admin__cell list-admin__cell--id"><?= $user->id ?></div>
                    <div class="list-admin__cell list-admin__cell--email"><?= $user->email ?></div>
                    <div class="list-admin__cell list-admin__cell--created-at"><?= $user->created_at ?></div>
                    <div class="list-admin__cell list-admin__cell--updated-at"><?= $user->updated_at ?></div>
                    <div class="list-admin__cell">
                        <form class="list-admin__form" method="POST" action="/admin/signeds/update-unreguser">
                            <input type="hidden" name="signed" value="<?= $user->signed ?>">
                            <button type="submit" name="unreg_user" class="btn <?= $user->signed ? 'btn--solid' : 'btn--transparent' ?>" value="<?= $user->id ?>">
                                <?= $user->signed ? 'Вкл' : 'Выкл' ?>
                            </button>
                        </form>
                        <form class="list-admin__form" method="POST" action="/admin/signeds/delete-unreguser">
                            <button type="submit" name="delete_unreg_signed" class="btn btn--transparent btn-post-delete" value="<?= $user->id ?>">Удалить</button>
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