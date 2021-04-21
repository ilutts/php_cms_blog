<main class="main">
    <div class="container">
        <h1 class="main__title">Авторизация</h1>

        <?php if (!empty($_SESSION['errorLogin'])) : ?>
            <h2 class="main__message main__message--error"><?= $_SESSION['errorLogin'] ?></h2>
        <?php endif ?>

        <?php if (empty($_SESSION['isAuth'])) { ?>
            <form class="form form--login" action="/login" method="post">
                <input type="email" class="input input--login" name="login" required="" placeholder="Логин - email" value="">
                <input type="password" class="input input--login" name="password" required="" placeholder="Пароль" value="">
                <button class="btn btn--solid btn--login" type="submit" name="submit">Войти</button>
                <a href="/registration" class="link link--login">Регистрация</a>
            </form>
        <?php } else { ?>
            <h2 class="main__message">Добро пожаловать, <b><?= $_SESSION['user']['name'] ?></b>!</h2>
        <?php } ?>

    </div>
</main>