<main class="main">
    <div class="container">
        <h1 class="main__title">Регистрация</h1>
        <?php if (empty($_SESSION['isAuth'])) { ?>
            <?php if (!empty($data)) : ?>
                <h2>Ошибка заполнения данных формы!</h2>
            <?php endif ?>

            <form class="form" action="/registration" method="post">
                <?php if (isset($data->name)) : ?>
                    <h2><?= $data->name ?></h2>
                <?php endif ?>
                <input type="text" class="input" name="name" placeholder="Ваше имя" value="<?= $data->nameOldValue ?? '' ?>">

                <?php if (isset($data->email)) : ?>
                    <h2><?= $data->email ?></h2>
                <?php endif ?>
                <input type="text" class="input" name="email" placeholder="Ваш E-mail" value="<?= $data->emailOldValue ?? '' ?>">

                <?php if (isset($data->passwordNew)) : ?>
                    <h2><?= $data->passwordNew ?></h2>
                <?php endif ?>
                <input type="password" class="input" name="password1" placeholder="Ваш пароль" value="">
                <input type="password" class="input" name="password2" placeholder="Подтверждение пароля" value="">

                <?php if (isset($data->rule)) : ?>
                    <h2><?= $data->rule ?></h2>
                <?php endif ?>
                <label class="label" for="checkbox-rule">Правила сайта:</label>
                <input type="checkbox" name="rule" id="checkbox-rule">

                <button class="btn btn--solid" type="submit" name="submit-reg">Регистрация</button>
            </form>
            <a href="/login" class="link">Авторизация</a>
        <?php } else { ?>
            <h2>Спасибо за регистрацию, <?= $_SESSION['user']['name'] ?></h2>
        <?php } ?>
    </div>
</main>