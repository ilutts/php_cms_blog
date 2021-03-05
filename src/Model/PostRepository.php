<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class PostRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('posts')) {
            Capsule::schema()->create('posts', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('short_description');
                $table->longText('description');
                $table->string('img')->nullable();
                $table->timestamps();
            });
        }
    }

    public static function add(string $name, string $shortDescription, string $description, string $img = null)
    {
        Post::firstOrCreate([
            'name' => $name,
            'short_description' => $shortDescription,
            'description' => $description,
            'img' => $img,
        ]);
    }
}