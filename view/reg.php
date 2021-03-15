<main class="main">    
    <div class="container">
        <h1 class="main__title">Регистрация</h1>
        <?php if (!empty($_SESSION['inputLogin'])): ?>
            <h2>Ошибка заполнения!</h2>
        <?php endif ?>
        <form class="form" action="/admin/" method="post">
            <input type="text" class="input" name="name" required placeholder="Ваше имя" value="">
            <input type="email" class="input" name="login" required placeholder="Ваш E-mail" value="">
            <input type="password" class="input" name="password" required placeholder="Ваш пароль" value="">
            <input type="password" class="input" name="password2" required placeholder="Подтверждение пароля" value="">
            <label for="checkbox-rule">Правила сайта:</label>
            <input type="checkbox" name="rule" id="checkbox-rule">
            <button class="btn btn--solid" type="submit" name="submit">Регистрация</button>
        </form>
        <a href="/login" class="link">Авторизация</a>
     </div> 
</main>