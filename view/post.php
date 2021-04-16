<main class="main">
    <div class="container">
        <h1 class="main__title">Сообщение</h1>
        <div class="list__item">
            <div class="list__box">
                <h2 class="list__title"><?= $data->title ?></h2>
                <p class="list__text"><?= $data->short_description ?></p>
                <p class="list__text"><?= $data->description ?></p>
                <p class="list__text">Дата публикации: <?= $data->created_at ?></p>
            </div>
            <div class="list__box">
                <img class="list__image" src="<?= $data->image ?>" alt="<?= $data->title ?>">
            </div>
        </div>
        <p class="list__text">Комментариев: <?= count($data->comments) ?></p>
        <div class="comment-box">
            <form class="comment-box__form form" method="post">
                <label class="comment-box__label label" for="new-comment">Оставить комментарий</label>
                <textarea name="comment-new" id="comment-new" class="input input--textarea"></textarea>
                <button class="btn btn--transparent" type="submit">Отправить</button>
                <?php if (!empty($data->newСomment)) : ?>
                    <h3><?= $data->newСomment ?></h3>
                <?php endif ?>
            </form>
            <ul>
                <?php foreach ($data->comments as $id => $comment) : ?>
                    <li>
                        <h3><?= $id + 1 ?>. <?= $comment->title ?></h3>
                        <p><?= $comment->text ?></p>
                        <p>Автор: <?= $comment->user->name ?></p>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</main>