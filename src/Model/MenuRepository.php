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
                $table->string('name')->unique();
                $table->string('title')->unique();
                $table->string('url')->unique();
                $table->timestamps();
            });
        }
    }

    public static function add(string $name, string $title, string $url)
    {
        Menu::firstOrCreate([
            'name' => $name,
            'title' => $title,
            'url' => $url,
        ]);
    }
}