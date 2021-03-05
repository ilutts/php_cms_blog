
<main class="main">
    <div class="container">
        <h1 class="main__title">Главная</h1>
        <div class="list__item">
            Подписаться на обновления 
            <input class="input" type="email" placeholder="Ваш E-mail">
            <button class="btn btn--solid" type="submit">Подписаться</button>
        </div>
        <ul class="list">
            <?php foreach ($data as $id => $post): ?>
                <li class="list__item">
                    <h2 class="list__title"><a href="/post/<?= $post->id ?>" class="link"><?= $post->name ?></a></h2>
                    <p class="list__text"><?= $post->short_description ?></p>
                    <p class="list__text">Дата публикации: <?= $post->created_at ?>,  Комментариев: <?= count($post->comments) ?></p>
                </li>
            <?php endforeach ?>
        </ul>
    </div> 
</main>
