<main class="main">
    <div class="container">
        <h1 class="main__title">Авторизация</h1>

        <?php if (!empty($_SESSION['errorLogin'])): ?>
            <h2>Неверный логин или пароль!</h2>
        <?php endif ?>

        <?php if (empty($_SESSION['isAuth'])) { ?>
            <form class="form" action="/login" method="post">
                <input type="email" class="input" name="login" required="" placeholder="Логин - email" value="">
                <input type="password" class="input" name="password" required="" placeholder="Пароль" value="">
                <button class="btn btn--solid" type="submit" name="submit">Войти в личный кабинет</button>
            </form>
            <a href="/registration" class="link">Регистрация</a>
        <?php } else { ?>
            <h2>И снова здраствуйте, <?= $_SESSION['user']['name'] ?></h2>
            <a href="/?exit" class="link">Выйти</a>
        <?php } ?>

    </div> 
</main>