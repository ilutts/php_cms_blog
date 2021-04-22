<?php

namespace App\Service;

use App\Model\Menu;
use App\Model\MenuRepository;
use App\Model\StaticPage;
use App\Model\StaticPageRepository;

class StaticPageService
{
    private int $id;
    private string $title;
    private string $name;
    private string $body;
    private bool $actived;
    private string $btnType;

    private array $error = [];

    public function getError()
    {
        return $this->error;
    }

    public static function get(int $numberSkipItems, int $maxItemsOnPage)
    {
        return StaticPage::skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }

    public function add(string $title, string $name, string $body, bool $actived, string $btnType)
    {
        $this->title = htmlspecialchars($title);
        $this->name = htmlspecialchars($name);
        $this->body = htmlspecialchars($body);
        $this->actived = $actived;
        $this->btnType = htmlspecialchars($btnType);

        if ($this->btnType === 'new' && $this->validate()) {

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

    public function update(int $id, string $title, string $name, string $body, bool $actived, string $btnType)
    {
        $this->id = $id;
        $this->title = htmlspecialchars($title);
        $this->name = htmlspecialchars($name);
        $this->body = htmlspecialchars($body);
        $this->actived = $actived;
        $this->btnType = htmlspecialchars($btnType);

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
        $validateService = new ValidateService();

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
