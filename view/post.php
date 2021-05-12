<main class="main">
    <div class="container">
        <h1 class="main__title">Сообщение</h1>
        <div class="list__item">
            <div class="list__box">
                <h2 class="list__title"><?= $data->title ?></h2>
                <p class="list__text list__text--short-decription"><?= $data->short_description ?></p>
                <p class="list__text"><?= $data->description ?></p>
                <div class="list__box-footer">
                    <p class="list__text">Дата публикации: <?= $data->created_at ?></p>
                </div>
            </div>
            <div class="list__box">
                <img class="list__image" src="<?= $data->image ?>" alt="<?= $data->title ?>">
            </div>
        </div>
        <p class="list__text">Комментариев: <?= count($data->comments) ?></p>
        <div class="comment-box">
            <ul class="comment-list">
                <?php foreach ($data->comments as $id => $comment) : ?>
                    <li class="comment-list__item">
                        <div class="comment-list__box">
                            <p class="comment-list__author">Автор: <b><?= $comment->user->name ?></b></p>
                            <img class="comment-list__img" src="<?= $comment->user->image ?>" alt="<?= $comment->user->name ?>">
                        </div>
                        <div class="comment-list__box comment-list__box--text">
                            <p class="comment-list__text"><b><?= $id + 1 ?>.</b> <?= $comment->text ?></p>
                            <p class="comment-list__footer"><b>Добавлен:</b> <?= $comment->created_at ?></p>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
            <form class="comment-box__form form" action="/comment/new" method="post">
                <label class="comment-box__label label" for="new-comment">Оставить комментарий</label>
                <textarea name="comment-new" id="comment-new" class="input input--textarea"></textarea>
                <input type="hidden" name="post_id" value="<?= $data->id ?>">
                <button class="btn btn--transparent" type="submit">Отправить</button>
                <?php if (!empty($data->newСomment)) : ?>
                    <h3><?= $data->newСomment ?></h3>
                <?php endif ?>
            </form>
        </div>
    </div>
</main>