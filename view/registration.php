<main class="main">
    <div class="container">
        <h1 class="main__title">Регистрация</h1>
        <?php if (empty($_SESSION['isAuth'])) { ?>
            <?php if (!empty($data)) : ?>
                <h2 class="main__message main__message--error">Ошибка заполнения данных формы!</h2>
            <?php endif ?>

            <form class="form" action="/registration" method="post">
                <?php if (isset($data->name)) : ?>
                    <h2 class="main__message main__message--error"><?= $data->name ?></h2>
                <?php endif ?>
                <label class="label" for="reg-name">Имя *</label>
                <input type="text" id="reg-name" class="input" name="name" placeholder="Ваше имя" value="<?= $data->nameOldValue ?? '' ?>">

                <?php if (isset($data->email)) : ?>
                    <h2 class="main__message main__message--error"><?= $data->email ?></h2>
                <?php endif ?>
                <label class="label" for="reg-email">Email *</label>
                <input type="text" id="reg-email" class="input" name="email" placeholder="Ваш E-mail" value="<?= $data->emailOldValue ?? '' ?>">

                <?php if (isset($data->passwordNew)) : ?>
                    <h2 class="main__message main__message--error"><?= $data->passwordNew ?></h2>
                <?php endif ?>
                <label class="label" for="reg-password">Пароль *</label>
                <input type="password" id="reg-password" class="input" name="password1" placeholder="Ваш пароль" value="">
                <label class="label" for="reg-password">Повторите пароль *</label>
                <input type="password" id="reg-password2" class="input" name="password2" placeholder="Подтверждение пароля" value="">

                <?php if (isset($data->rule)) : ?>
                    <h2 class="main__message main__message--error"><?= $data->rule ?></h2>
                <?php endif ?>
                <label class="label" for="checkbox-rule">Правила сайта: <input type="checkbox" name="rule" id="checkbox-rule"></label>
                <div class="form__box">                
                    <button class="btn btn--solid" type="submit" name="submit-reg">Регистрация</button>
                    <a href="/login" class="link">Авторизация</a>
                </div>
            </form>
        <?php } else { ?>
            <h2 class="main__message">Спасибо за регистрацию, <b><?= $_SESSION['user']['name'] ?></b></h2>
        <?php } ?>
    </div>
</main>