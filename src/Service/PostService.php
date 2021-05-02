<?php

namespace App\Service;

use App\Model\Post;
use App\Model\PostRepository;

class PostService
{
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

    public function add(string $title, string $shortDescription, string $description, int $userId, array $image, bool $actived)
    {
        $title = strip_tags($title);
        $shortDescription = strip_tags($shortDescription);
        $description = strip_tags($description);

        if ($this->validate($title, $shortDescription, $description, $image ?? [])) {
            if (!empty($image['name'])) {
                move_uploaded_file(
                    $image['tmp_name'],
                    $_SERVER['DOCUMENT_ROOT'] . UPLOAD_POST_DIR . $image['name']
                );
    
                $imageSrc = UPLOAD_POST_DIR . rawurlencode($image['name']);
            }

            $post = PostRepository::add(
                $title,
                $shortDescription,
                $description,
                $userId,
                $actived,
                $imageSrc ?? '/img/post/post-no-img.png'
            );

            $mailServices = new MailService();
            $mailServices->send($post);
        }

        return $this->error;
    }

    public function update(int $postId, string $title, string $shortDescription, string $description, int $userId, array $image, bool $actived)
    {
        $title = strip_tags($title);
        $shortDescription = strip_tags($shortDescription);
        $description = strip_tags($description);

        if ($this->validate($title, $shortDescription, $description, $image)) {
            $data = [
                'title' => $title,
                'short_description' => $shortDescription,
                'description' => $description,
                'user_id' => $userId,
                'actived' => $actived
            ];

            if (!empty($image['name'])) {
                move_uploaded_file(
                    $image['tmp_name'],
                    $_SERVER['DOCUMENT_ROOT'] . UPLOAD_POST_DIR . $image['name']
                );

                $data['image'] = UPLOAD_POST_DIR . rawurlencode($image['name']);
            }

            PostRepository::update(
                $postId,
                $data,
            );
        }

        return $this->error;
    }

    private function validate(string $title, string $shortDescription, string $description, array $image): bool
    {
        $validateService = new ValidateService();

        $validateService->checkText($title, 'title');
        $validateService->checkText($shortDescription, 'short_description');
        $validateService->checkText($description, 'description');

        if ($image) {
            $validateService->checkImage($image);
        }

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            return false;
        }

        return true;
    }
}
