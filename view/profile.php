<main class="main">
    <div class="container main__container">
        <h1 class="main__title">Личный кабинет</h1>
        <?php if ($data) { ?>
            <form class="profile-form" action="/profile/update/info" method="post" enctype="multipart/form-data">
                <div class="profile-form__box">
                    <?php if (isset($data->error['name'])) : ?>
                        <h3 class="main__message main__message--error"><?= $data->error['name'] ?></h3>
                    <?php endif ?>
                    <label class="label" for="profile_name">Имя</label>
                    <input id="profile_name" type="text" class="input" name="name" placeholder="Ваше имя" value="<?= $data->name ?>">

                    <?php if (isset($data->error['email'])) : ?>
                        <h3 class="main__message main__message--error"><?= $data->error['email'] ?></h3>
                    <?php endif ?>
                    <label class="label" for="profile_email">E-mail</label>
                    <input id="profile_email" type="text" class="input" name="email" placeholder="Ваш E-mail" value="<?= $data->email ?>">

                    <label class="label" for="checkbox-rule">О себе:</label>
                    <textarea class="input input--textarea" name="about" id="profile_about"><?= $data->about ?></textarea>
                </div>
                <div class="profile-form__box">
                    <?php if (isset($data->error['image'])) : ?>
                        <h3 class="main__message main__message--error"><?= $data->error['image'] ?></h3>
                    <?php endif ?>
                    <label class="label" for="checkbox-rule">Ваше фото:</label>
                    <img class="profile-form__image" src="<?= $data->image ?>" alt="Аватар" width="100px">
                    <input class="input" type="file" name="image" id="profile_image">
                    <button class="btn btn--solid" type="submit" name="submit-info">Сохранить</button>
                    <?php if (isset($data->success['update_info'])) : ?>
                        <h3 class="main__message main__message--success">Данные пользователя обновленны!</h3>
                    <?php endif ?>
                </div>
            </form>
            <div class="profile-form">
                <div class="profile-form__box">
                    <form class="form form--profile" action="/profile/update/password" method="post">
                        <h2>Изменение пароля</h2>
                        <?php if (isset($data->success['update_pass'])) : ?>
                            <h3 class="main__message main__message--success">Пароль изменён!</h3>
                        <?php endif ?>

                        <?php if (isset($data->error['passwordOld'])) : ?>
                            <h3 class="main__message main__message--error"><?= $data->error['passwordOld'] ?></h3>
                        <?php endif ?>
                        <label class="label" for="profile_password_old">Старый пароль</label>
                        <input id="profile_password_old" type="password" class="input" name="password_old" placeholder="Введите старый пароль" value="">

                        <?php if (isset($data->error['passwordNew'])) : ?>
                            <h3 class="main__message main__message--error"><?= $data->error['passwordNew'] ?></h3>
                        <?php endif ?>
                        <label class="label" for="profile_password1">Новый пароль</label>
                        <input id="profile_password1" type="password" class="input" name="password1" placeholder="Введите новый пароль" value="">
                        <label class="label" for="profile_password2">Повторите новый пароль</label>
                        <input id="profile_password2" type="password" class="input" name="password2" placeholder="Введите подтверждение пароля" value="">
                        <button class="btn btn--solid" type="submit" name="submit-password">Изменить пароль</button>
                    </form>
                </div>
                <div class="profile-form__box">
                    <form class="form" action="/profile/update/signed" method="post">
                        <h2>Подписка на обновления</h2>

                        <p><?= $data->signed ? 'Вы уже подписаны' : 'Хотите подписаться?' ?></p>
                        <button class="btn btn--solid" type="submit" name="submit-signed"><?= $data->signed ? 'Отписаться' : 'Подписаться' ?></button>
                        <?php if (isset($data->success['update_signed'])) : ?>
                            <h3 class="main__message main__message--success">Вы успешно <?= $data->signed ? 'подписались на рассылку' : 'отписались от рассылки' ?></h3>
                        <?php endif ?>
                    </form>
                </div>
            </div>

        <?php } else { ?>
            <h2 class="main__message main__message--error">Страница не доступна!</h2>
        <?php } ?>
    </div>
</main>