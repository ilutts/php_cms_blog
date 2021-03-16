<main class="main">    
    <div class="container">
        <h1 class="main__title">Регистрация</h1>

        <?php if (!empty($data)): ?>
            <h2>Ошибка заполнения данных формы!</h2>
        <?php endif ?>

        <form class="form" action="/registration" method="post">
            <?php if (isset($data['name'])): ?>
                <h2>Ошибка заполнения имени!</h2>
            <?php endif ?>
            <input 
                type="text" 
                class="input" 
                name="name" 
                placeholder="Ваше имя" 
                value="<?= isset($data['name']) ? $data['name'] : '' ?>"
            >

            <?php if (isset($data['email'])): ?>
                <h2>Ошибка заполнения почты!</h2>
            <?php endif ?>
            <input 
                type="text" 
                class="input" 
                name="email"  
                placeholder="Ваш E-mail" 
                value="<?= isset($data['email']) ? $data['email'] : '' ?>"
            >

            <?php if (isset($data['password'])): ?>
                <h2>Ошибка заполнения пароля</h2>
            <?php endif ?>
            <input type="password" class="input" name="password1" placeholder="Ваш пароль" value="">
            <input type="password" class="input" name="password2" placeholder="Подтверждение пароля" value="">

            <?php if (isset($data['rule'])): ?>
                <h2>Необходимо согласится с правилами!</h2>
            <?php endif ?>
            <label for="checkbox-rule">Правила сайта:</label>
            <input type="checkbox" name="rule" id="checkbox-rule">

            <button class="btn btn--solid" type="submit" name="submit-reg">Регистрация</button>
        </form>
        <a href="/login" class="link">Авторизация</a>
     </div> 
</main>