<?php

namespace App\Service;

use App\Config;
use App\Model\Post;
use App\Model\PostRepository;

class PostService
{
    private string $title;
    private string $shortDescription;
    private string $description;
    private array $image;

    private array $error = [];

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

    public function add(string $title, string $shortDescription, string $description, int $userId, array $image, bool $actived, string $btnPost)
    {
        $this->title = htmlspecialchars($title);
        $this->shortDescription = htmlspecialchars($shortDescription);
        $this->description = htmlspecialchars($description);
        $this->image = $image;

        if ($btnPost === 'new' && $this->validate()) {
            $post = PostRepository::add(
                $this->title,
                $this->shortDescription,
                $this->description,
                $userId,
                $actived,
                $this->image['new'] ?? '/img/post/post-no-img.png'
            );

            $mailServices = new MailService();
            $mailServices->send($post);
        }

        return $this->error;
    }

    public function update(int $postId, string $title, string $shortDescription, string $description, int $userId, array $image, bool $actived, string $btnPost)
    {
        $this->title = htmlspecialchars($title);
        $this->shortDescription = htmlspecialchars($shortDescription);
        $this->description = htmlspecialchars($description);
        $this->image = $image;

        if ($btnPost === 'change' && $this->validate()) {
            $data = [
                'title' => $this->title,
                'short_description' => $this->shortDescription,
                'description' => $this->description,
                'user_id' => $userId,
                'actived' => $actived
            ];

            if (isset($this->image['new'])) {
                move_uploaded_file(
                    $this->image['tmp_name'],
                    $_SERVER['DOCUMENT_ROOT'] . UPLOAD_POST_DIR . $this->image['name']
                );

                $data['image'] = UPLOAD_POST_DIR . $this->image['name'];
            }

            PostRepository::update(
                $postId,
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
