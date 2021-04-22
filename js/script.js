function changeImageOfInputFile(input, img) {
  input.addEventListener('change', (evt) => {
    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
    };

    reader.readAsDataURL(file);
  });
}

function ajaxPopupAdminPost(form, formData, popupImg) {
  form.submit_post.textContent = 'Изменить';
  form.submit_post.value = 'change';

  fetch('/ajax/post/get', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      form.querySelector('.popup__id').textContent = data.id;
      form.id.value = data.id;
      form.title.value = data.title;
      form.short_description.value = data.short_description;
      form.description.value = data.description;
      form.post_actived.checked = data.actived;
      popupImg.setAttribute('src', data.image);
    })
    .catch((error) => console.log(error));
}

function ajaxPopupAdminStaticPage(form, formData) {
  form.submit_post.textContent = 'Изменить';
  form.submit_post.value = 'change';

  fetch('/ajax/static/get', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      form.querySelector('.popup__id').textContent = data.id;
      form.id.value = data.id;
      form.name.value = data.name;
      form.title.value = data.title;
      form.body.value = data.body;
      form.post_actived.checked = data.actived;
    })
    .catch((error) => console.log(error));
}

function ajaxPopupAdminUser(form, formData, popupImg) {
  form.roles.innerHTML = '';

  fetch('/ajax/user/get', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      form.querySelector('.popup__id').textContent = data.id;
      form.id.value = data.id;
      form.email.value = data.email;
      form.name.value = data.name;
      form.about.value = data.about;
      form.user_actived.checked = data.actived;
      popupImg.setAttribute('src', data.image);

      data.allroles.forEach((role) => {
        let selected = data.roles.find((roleUser) => roleUser.id == role.id) ? true : false;
        let option = new Option(role.name, role.id, selected, selected);
        form.roles.append(option);
      });
    })
    .catch((error) => console.log(error));
}

function appBlog() {
  const adminListPosts = document.querySelector('.main-admin__list--posts');
  const formProfile = document.querySelector('.form--profile');
  const formCountItemAdmin = document.querySelector('.main__form--admin');

  if (formCountItemAdmin) {
    // Получаем параметры GET
    let getParams = new URL(document.location).searchParams;
    const countItemValue = getParams.get('quantity') ?? 20;

    formCountItemAdmin.quantity.value = countItemValue === 'all' ? 'all' : +countItemValue;

    formCountItemAdmin.quantity.addEventListener('change', () => {
      formCountItemAdmin.submit();
    });
  }

  if (formProfile) {
    const userImg = document.querySelector('.profile-form__image');
    const inputImg = document.querySelector('#profile_image');

    changeImageOfInputFile(inputImg, userImg);
  }

  if (adminListPosts) {
    const popup = document.querySelector('.popup');
    const formPopup = popup.querySelector('.popup__form');
    const btnNew = document.querySelector('.btn-new');
    const inputImg = document.querySelector('#popup_image');
    const popupImg = popup.querySelector('.popup__image');

    popup.addEventListener('click', (event) => {
      if (event.target == popup) {
        popup.style.display = 'none';
        formPopup.reset();
      }
    });

    if (inputImg) {
      changeImageOfInputFile(inputImg, popupImg);
    }

    adminListPosts.addEventListener('click', (event) => {
      if (event.target.classList.contains('btn-post-change')) {
        popup.style.display = 'flex';

        const id = +event.target.parentElement.querySelector('.list-admin__cell--id').textContent;
        const formData = new FormData();
        formData.append('id', id);

        if (formPopup.classList.contains('form--admin-post')) {
          ajaxPopupAdminPost(formPopup, formData, popupImg);
        }

        if (formPopup.classList.contains('form--admin-user')) {
          ajaxPopupAdminUser(formPopup, formData, popupImg);
        }

        if (formPopup.classList.contains('form--admin-static')) {
          ajaxPopupAdminStaticPage(formPopup, formData);
        }
      }
    });

    if (btnNew) {
      btnNew.addEventListener('click', () => {
        popup.style.display = 'flex';
        formPopup.querySelector('.popup__id').textContent = 'Новая';
        formPopup.submit_post.textContent = 'Добавить';
        formPopup.submit_post.value = 'new';
        if (popupImg) {
          popupImg.setAttribute('src', '/img/post/post-no-img.png');
        }
      });
    }
  }
}

appBlog();
