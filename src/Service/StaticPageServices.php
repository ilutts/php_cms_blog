<?php

namespace App\Service;

use App\Model\Menu;
use App\Model\MenuRepository;
use App\Model\StaticPage;
use App\Model\StaticPageRepository;

class StaticPageServices
{
    private int $id;
    private string $title;
    private string $name;
    private string $body;
    private bool $actived;
    private string $btnPost;

    private array $error = [];

    private function setData()
    {
        $this->id = intval($_POST['id'] ?? 0);
        $this->title = htmlspecialchars($_POST['title'] ?? '');
        $this->name = htmlspecialchars($_POST['name'] ?? '');
        $this->body = htmlspecialchars($_POST['body'] ?? '');
        $this->actived = boolval($_POST['post_actived'] ?? 0);
        $this->btnPost = htmlspecialchars($_POST['submit_post'] ?? '');
    }

    public function getError()
    {
        return $this->error;
    }

    public static function get()
    {
        $countPages = (int)StaticPage::count();
        $maxItemOnPage = $_GET['quantity'] ?? 20;

        if ($maxItemOnPage === 'all') {
            $maxItemOnPage = $countPages;
        } else {
            $maxItemOnPage = (int)$maxItemOnPage;
        }

        $skipPosts = 0;

        if (!empty($_GET['page']) && $_GET['page'] > 1) {
            $page = (int)$_GET['page'];
            $skipPosts = $page * $maxItemOnPage - $maxItemOnPage;
        }

        $pages = StaticPage::skip($skipPosts)->take($maxItemOnPage)->get();
        $pages->countPages = ceil($countPages / $maxItemOnPage);

        return $pages;
    }

    public function new()
    {
        $this->setData();
        
        if ($this->btnPost === 'new' && $this->validate()) {

            $page = StaticPageRepository::add(
                $this->title,
                $this->name,
                $this->body,
                $this->actived
            );

            if ($this->actived) {
                MenuRepository::add($this->title, '/page/' . $this->name, $page->id);
            }
        }
    }

    public function change()
    {
        $this->setData();

        if ($this->btnPost === 'change' && $this->validate()) {
            $data = [
                'title' => $this->title,
                'name' => $this->name,
                'body' => $this->body,
                'actived' => $this->actived
            ];

            StaticPageRepository::update(
                $this->id,
                $data,
            );

            if (Menu::where('static_page_id', $this->id)->exists()) {
                if (!$this->actived) {
                    MenuRepository::delete($this->id);
                }
            } else {
                if ($this->actived) {
                    MenuRepository::add($this->title, '/page/' . $this->name, $this->id); 
                }
            }
        }
    }

    private function validate(): bool
    {
        $validateService = new ValidateServices();

        $validateService->checkText($this->title, 'title');
        $validateService->checkText($this->name, 'name');
        $validateService->checkTextForLink($this->name, 'name');
        $validateService->checkText($this->body, 'body');

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            return false;
        }

        return true;
    }
}