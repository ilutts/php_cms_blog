<?php

namespace App\Service;

use App\Config;
use App\Model\Post;
use App\Model\PostRepository;

class PostService
{
    private int $id;
    private string $title;
    private string $shortDescription;
    private string $description;
    private array $image;
    private bool $actived;
    private string $btnPost;

    private array $error = [];

    private function setData()
    {
        $this->id = intval($_POST['id'] ?? 0);
        $this->title = htmlspecialchars($_POST['title'] ?? '');
        $this->shortDescription = htmlspecialchars($_POST['short_description'] ?? '');
        $this->description = htmlspecialchars($_POST['description'] ?? '');
        $this->image = $_FILES['image'] ?? [];
        $this->actived = boolval($_POST['post_actived'] ?? 0);
        $this->btnPost = htmlspecialchars($_POST['submit_post'] ?? '');
    }

    public function getError()
    {
        return $this->error;
    }

    public static function getForAdmin(int $numberSkipItems, int $maxItemsOnPage)
    {
        return Post::select('id', 'title', 'created_at', 'updated_at', 'actived', 'user_id')->orderByDesc('id')->skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }

    public static function get(int $numberSkipItems, int $maxItemsOnPage)
    {
        return Post::where('actived', 1)->with(['comments' => function ($query) {
            $query->where('approved', 1);
        }])->orderByDesc('id')->skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }

    public function new(int $userId)
    {
        $this->setData();

        if ($this->btnPost === 'new' && $this->validate()) {
            $post = PostRepository::add(
                $this->title,
                $this->shortDescription,
                $this->description,
                $userId,
                $this->actived,
                $this->image['new'] ?? '/img/post/post-no-img.png'
            );

            $mailServices = new MailService();
            $mailServices->send($post);
        }

        return $this->error;
    }

    public function change(int $userId)
    {
        $this->setData();

        if ($this->btnPost === 'change' && $this->validate()) {
            $data = [
                'title' => $this->title,
                'short_description' => $this->shortDescription,
                'description' => $this->description,
                'user_id' => $userId,
                'actived' => $this->actived
            ];

            if (isset($this->image['new'])) {
                move_uploaded_file(
                    $this->image['tmp_name'],
                    $_SERVER['DOCUMENT_ROOT'] . UPLOAD_POST_DIR . $this->image['name']
                );

                $data['image'] = UPLOAD_POST_DIR . $this->image['name'];
            }

            PostRepository::update(
                $this->id,
                $data,
            );
        }

        return $this->error;
    }

    private function validate(): bool
    {
        $validateService = new ValidateService();

        $validateService->checkText($this->title, 'title');
        $validateService->checkText($this->shortDescription, 'short_description');
        $validateService->checkText($this->description, 'description');

        if ($this->image && $validateService->checkImage($this->image)) {
            move_uploaded_file(
                $this->image['tmp_name'],
                $_SERVER['DOCUMENT_ROOT'] . UPLOAD_POST_DIR . $this->image['name']
            );

            $this->image['new'] = UPLOAD_POST_DIR . $this->image['name'];
        }

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            return false;
        }

        return true;
    }
}
