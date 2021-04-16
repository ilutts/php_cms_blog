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

function appBlog() {
  const adminListPosts = document.querySelector('.main-admin__list');
  const formProfile = document.querySelector('.form--profile');

  if (formProfile) {
    const userImg = document.querySelector('.profile-form__image');
    const inputImg = document.querySelector('#profile_image');

    changeImageOfInputFile(inputImg, userImg);
  }

  if (adminListPosts) {
    const popup = document.querySelector('.popup');
    const form = popup.querySelector('.form--admin-post');
    const btnNewPost = document.querySelector('.btn-new-post');
    const inputImg = document.querySelector('#post_image');
    const postImg = form.querySelector('.popup__image');

    popup.addEventListener('click', (event) => {
      if (event.target == popup) {
        popup.style.display = 'none';
        form.reset();
      }
    });

    changeImageOfInputFile(inputImg, postImg);

    adminListPosts.addEventListener('click', (event) => {
      if (event.target.classList.contains('btn-post-change')) {
        popup.style.display = 'flex';

        const id = +event.target.parentElement.querySelector('.list__cell--id').textContent;
        const formData = new FormData();

        formData.append('post_id', id);

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
            form.post_active.checked = data.actived;
            postImg.setAttribute('src', data.image);
          })
          .catch((error) => console.log(error));
      }
    });

    btnNewPost.addEventListener('click', () => {
      popup.style.display = 'flex';
      form.querySelector('.popup__id').textContent = 'Новая';
      form.submit_post.textContent = 'Добавить';
      form.submit_post.value = 'new';
    });
  }
}

appBlog();
