<main class="main">    
    <div class="container">
        <h1 class="main__title">Личный кабинет</h1>
        <?php if ($data) { ?>
            <form class="profile-form" action="/profile" method="post" enctype="multipart/form-data">
                <div class="profile-form__box">
                    <label for="profile_name">Имя</label>
                    <input 
                        id="profile_name"
                        type="text" 
                        class="input" 
                        name="name" 
                        placeholder="Ваше имя" 
                        value="<?= $data->name ?>"
                    >

                    <label for="profile_email">E-mail</label>
                    <input 
                        id="profile_email"
                        type="text" 
                        class="input" 
                        name="email"
                        placeholder="Ваш E-mail" 
                        value="<?= $data->email ?>"
                    >

                    <label for="checkbox-rule">О себе:</label>
                    <textarea class="input input--textarea" name="about" id="profile_about"><?= $data->about ?></textarea>
                </div>
                <div class="profile-form__box">
                    <label for="checkbox-rule">Ваше фото:</label>
                    <img src="<?= $data->image ?>" alt="Аватар" width="100px">
                    <input class="input" type="file" name="image" id="profile_image">  
                    <button class="btn btn--solid" type="submit" name="submit-info">Сохранить</button>
                </div>
            </form>
            <div class="profile-form">
                <div class="profile-form__box">
                    <form class="form" action="/profile" method="post">
                        <h2>Изменение пароля</h2>
                        <label for="profile_password_old">Старый пароль</label>
                        <input id="profile_password_old" type="password" class="input" name="password-old" placeholder="Введите старый пароль" value="">
                        <label for="profile_password1">Новый пароль</label>
                        <input id="profile_password1" type="password" class="input" name="password1" placeholder="Введите новый пароль" value="">
                        <label for="profile_password2">Повторите новый пароль</label>
                        <input id="profile_password2" type="password" class="input" name="password2" placeholder="Введите подтверждение пароля" value="">
                        <button class="btn btn--solid" type="submit" name="submit-password">Изменить пароль</button>
                    </form>
                </div>
                <div class="profile-form__box">
                    <form class="form" action="/profile" method="post">
                        <h2>Подписка на обновления</h2>
            
                        <p><?= $data->signed ? 'Вы уже подписаны' : 'Хотите подписаться?' ?></p>
                        <button class="btn btn--solid" type="submit" name="submit-signed"><?= $data->signed ? 'Отписаться' : 'Подписаться' ?></button>
                    </form>
                </div>
            </div>

        <?php } else { ?>
            <h2>Страница не доступна!</h2>
        <?php } ?>
    </div>
</main>