<main class="main">
    <div class="container">
        <h1 class="main__title">Сообщение</h1>
        <div class="list__item">
            <h2 class="list__title"><?= $data->name ?></h2>
            <p class="list__text"><?= $data->short_description ?></p>
            <p class="list__text"><?= $data->description ?></p>
            <p class="list__text">Дата публикации: <?= $data->created_at ?></p>
            <p class="list__text">Комментариев: <?= count($data->comments) ?></p>
            <ul>
                <?php foreach ($data->comments as $id => $comment): ?>
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