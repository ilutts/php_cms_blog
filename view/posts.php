<main class="main">
    <div class="container">
        <h1 class="main__title">Главная</h1>
        <?php if (!empty($data['posts']->successForm)) : ?>
            <h2 class="main__message main__message--success"><?= $data['posts']->successForm ?></h2>
        <?php endif ?>
        <?php if (isset($data['posts']->errorForm)) : ?>
            <h2 class="main__message main__message--error"><?= $data['posts']->errorForm['email'] ?></h2>
        <?php endif ?>
        <?php if (empty($_SESSION['user']['signed'])) : ?>
            <form class="form form--main" action="/subscribe" method="post">
                Подписаться на обновления

                <?php if (empty($_SESSION['isAuth'])) : ?>
                    <input class="input input--main-signed" type="email" name="email" id="main_input_email" placeholder="Ваш E-mail" required>
                <?php endif ?>

                <button class="btn btn--solid" type="submit" name="submit-signed">Подписаться</button>
            </form>
        <?php endif ?>
        <ul class="list">
            <?php foreach ($data['posts'] as $post) : ?>
                <li class="list__item">
                    <div class="list__box">
                        <h2 class="list__title"><a href="/post/<?= $post->id ?>" class="link"><?= $post->title ?></a></h2>
                        <p class="list__text list__text--short-decription"><?= $post->short_description ?></p>
                        <div class="list__box-footer">
                            <p class="list__text">Дата публикации: <?= $post->created_at ?></p>
                            <p class="list__text">Комментариев: <?= count($post->comments) ?></p>
                        </div>
                    </div>
                    <div class="list__box">
                        <img class="list__image" src="<?= $post->image ?>" alt="<?= $post->title ?>">
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
        <ul class="main__paginator paginator">
            <?php for ($i = 1; $i <= $data['count_pages']; $i++) : ?>
                <li class="paginator__item">
                    <a class="paginator__link" <?= getStatusPage($i) ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>
        </ul>
    </div>
</main>