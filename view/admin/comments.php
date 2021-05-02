<main class="main">
    <div class="container">
        <h1 class="main__title">Комментарии - Админ-панель</h1>
        <div class="main-admin__header">
            <form class="main__form main__form--admin" method="GET">
                <label for="form__select-quantity">Комментариев на странице:</label>
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
            <li class="list-admin__item list-admin__item--comments">
                <div class="list-admin__cell list-admin__cell--bold">ID</div>
                <div class="list-admin__cell list-admin__cell--bold">Статья</div>
                <div class="list-admin__cell list-admin__cell--bold">Текст</div>
                <div class="list-admin__cell list-admin__cell--bold">Пользователь</div>
                <div class="list-admin__cell list-admin__cell--bold">Статус</div>
            </li>
            <?php foreach ($data['comments'] as $comment) : ?>
                <li class="list-admin__item list-admin__item--comments">
                    <div class="list-admin__cell list-admin__cell--id"><?= $comment->id ?></div>
                    <div class="list-admin__cell list-admin__cell--post">
                        <a class="link" href="/post/<?= $comment->post->id ?>"><?= $comment->post->title ?></a>
                    </div>
                    <div class="list-admin__cell list-admin__cell--text"><?= $comment->text ?></div>
                    <div class="list-admin__cell list-admin__cell--user"><?= $comment->user->name ?></div>
                    <form class="list-admin__form" method="POST">
                        <input type="hidden" name="id" value="<?= $comment->id ?>">
                        <input type="hidden" name="approved" value="<?= $comment->approved ?>">
                        <button type="submit" name="comment_approved" class="btn <?= $comment->approved ? 'btn--solid' : 'btn--transparent' ?>"><?= $comment->approved ? 'Одобрен' : 'Не одобрен' ?></button>
                        <button type="submit" name="delete_comment" class="btn btn--transparent btn-post-delete">Удалить</button>
                    </form>
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