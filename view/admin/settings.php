<main class="main">
    <div class="container">
        <h1 class="main__title">Настройки CMS - Админ-панель</h1>
        <form class="form" action="/admin/settings/save" method="post">
            <label class="label" for="site_name">Название сайта:
                <input type="text" id="site_name" class="input" name="site_name" placeholder="Введите название сайта" value="<?= $data['site_name'] ?? '' ?>" required minlength="1">
            </label>
            <label class="label" for="quantity_posts_main">Количество статей на главной:
                <input type="number" id="quantity_posts_main" class="input" name="quantity_posts_main" placeholder="Введите число" value="<?= $data['quantity_posts_main'] ?? '' ?>" required minlength="1">
            </label>
            <label class="label" for="mailing_list">
                Включить рассылку на почту:
                <input type="checkbox" name="mailing_list" id="mailing_list" <?= $data['mailing_list'] ? 'checked' : '' ?>>
                <a class="link" href="/log_mail.txt"> Открыть лог почты</a>
            </label>
            <div class="form__box">
                <button class="btn btn--solid" type="submit" name="submit-setting">Сохранить</button>
            </div>
        </form>
    </div>
</main>