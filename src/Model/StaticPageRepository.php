<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class StaticPageRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('static_pages')) {
            Capsule::schema()->create('static_pages', function ($table) {
                $table->increments('id');
                $table->string('title');
                $table->longText('body');
                $table->string('name')->unique();
                $table->boolean('actived')->default(0);
                $table->timestamps();
            });
        }
    }

    public static function add(string $title, string $body, string $name, bool $actived = false)
    {
        return StaticPage::firstOrCreate([
            'title' => $title,
            'body' => $body,
            'name' => $name,
            'actived' => $actived,
        ]);
    }

    public static function update(int $id, array $data)
    {
        return StaticPage::where('id', $id)->update($data);
    }

    public static function delete(int $id)
    {
        return StaticPage::destroy($id);
    }
}
