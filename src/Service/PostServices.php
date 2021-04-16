<?php

namespace App\Service;

use App\Config;
use App\Model\Post;
use App\Model\PostRepository;

class PostServices
{
    private int $id;
    private string $title;
    private string $shortDescription;
    private string $description;
    private array $image;
    private bool $actived;
    private string $btnPost;

    private function setData()
    {
        $this->id = intval($_POST['id'] ?? 0);
        $this->title = htmlspecialchars($_POST['title'] ?? '');
        $this->shortDescription = htmlspecialchars($_POST['short_description'] ?? '');
        $this->description = htmlspecialchars($_POST['description'] ?? '');
        $this->image = $_FILES['image'] ?? [];
        $this->actived = boolval($_POST['post_active'] ?? 0);
        $this->btnPost = htmlspecialchars($_POST['submit_post'] ?? '');
    }

    public function get(string $forPage = 'main')
    {
        switch ($forPage) {
            case 'main':
                $configsCount = 'cms.quantity_posts_main';
                break;

            case 'admin':
                $configsCount = 'cms.quantity_posts_admin';
                break;
        }

        $countPosts = (int)Post::count();
        $maxPostsOnPage = (int)Config::getInstance()->get($configsCount);
        $skipPosts = 0;

        if (!empty($_GET['page']) && $_GET['page'] > 1) {
            $page = (int)$_GET['page'];
            $skipPosts = $page * $maxPostsOnPage - $maxPostsOnPage;
        }

        switch ($forPage) {
            case 'main':
                $posts = Post::where('actived', true)->with('comments')->orderByDesc('id')->skip($skipPosts)->take($maxPostsOnPage)->get();
                break;

            case 'admin':
                $posts = Post::select('id', 'title', 'created_at', 'updated_at', 'actived', 'user_id')->orderByDesc('id')->skip($skipPosts)->take($maxPostsOnPage)->get();
                break;
        }

        $posts->countPages = ceil($countPosts / $maxPostsOnPage);

        return $posts;
    }

    public function new(int $userId)
    {
        $this->setData();

        if ($this->btnPost === 'new' && $this->validateNew()) {
            if ($this->image) {
                move_uploaded_file(
                    $this->image['tmp_name'],
                    $_SERVER['DOCUMENT_ROOT'] . UPLOAD_POST_DIR . $this->image['name']
                );

                $this->image['new'] = UPLOAD_POST_DIR . $this->image['name'];
            }

            PostRepository::add(
                $this->title,
                $this->shortDescription,
                $this->description,
                $userId,
                $this->actived,
                $this->image['new'] ?? ''
            );
        }
    }

    public function change(int $userId)
    {
        $this->setData();

        if ($this->btnPost === 'change' && $this->validateNew()) {
            $data = [
                'title' => $this->title,
                'short_description' => $this->shortDescription,
                'description' => $this->description,
                'user_id' => $userId,
                'actived' => $this->actived
            ];

            if ($this->image) {
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
    }

    private function validateNew(): bool
    {
        $validateService = new ValidateServices();

        $validateService->checkText($this->title, 'title');
        $validateService->checkText($this->shortDescription, 'short_description');
        $validateService->checkText($this->description, 'description');

        if ($this->image) {
            $validateService->checkImage($this->image);
        }

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            return false;
        }

        return true;
    }
}
