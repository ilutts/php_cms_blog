<?php

namespace App\Service;

use App\Model\Menu;
use App\Model\MenuRepository;
use App\Model\StaticPage;
use App\Model\StaticPageRepository;

class StaticPageService
{
    private array $error = [];

    public function getError()
    {
        return $this->error;
    }

    public static function get(int $numberSkipItems, int $maxItemsOnPage)
    {
        return StaticPage::skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }

    public function add(string $title, string $name, string $body, bool $actived = true)
    {
        $title = strip_tags($title);
        $name = strip_tags($name);
        $body = strip_tags($body);

        if ($this->validate($title, $name, $body)) {

            $page = StaticPageRepository::add(
                $title,
                $body,
                $name,
                $actived
            );

            if ($actived) {
                MenuRepository::add($title, '/page/' . $name, $page->id);
            }
        }
    }

    public function update(int $id, string $title, string $name, string $body, bool $actived)
    {
        $title = strip_tags($title);
        $name = strip_tags($name);
        $body = strip_tags($body);

        if ($this->validate($title, $name, $body)) {
            $data = [
                'title' => $title,
                'name' => $name,
                'body' => $body,
                'actived' => $actived
            ];

            StaticPageRepository::update(
                $id,
                $data,
            );

            if (Menu::where('static_page_id', $id)->exists()) {
                if (!$actived) {
                    MenuRepository::delete($id);
                }
            } else {
                if ($actived) {
                    MenuRepository::add($title, '/page/' . $name, $id);
                }
            }
        }
    }

    private function validate(string $title, string $name, string $body): bool
    {
        $validateService = new ValidateService();

        $validateService->checkText($title, 'title');
        $validateService->checkText($name, 'name');
        $validateService->checkTextForLink($name, 'name');
        $validateService->checkText($body, 'body');

        if ($validateService->getError()) {
            $this->error = $validateService->getError();
            return false;
        }

        return true;
    }
}
