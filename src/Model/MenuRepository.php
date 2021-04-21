<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class MenuRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('menus')) {
            Capsule::schema()->create('menus', function ($table) {
                $table->increments('id');
                $table->string('title')->unique();
                $table->string('url')->unique();
                $table->integer('static_page_id')->unsigned();
                $table->timestamps();
            });
        }
    }

    public static function add(string $title, string $url, int $staticPageId)
    {
        Menu::firstOrCreate([
            'title' => $title,
            'url' => $url,
            'static_page_id' => $staticPageId
        ]);
    }

    public static function delete(int $staticPageId)
    {
        Menu::where('static_page_id', $staticPageId)->delete();
    }
}
