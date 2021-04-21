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
                $table->string('title');
                $table->string('short_description');
                $table->longText('description');
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->boolean('actived')->default(0);
                $table->string('image')->default('/img/post/post-no-img.png');
                $table->timestamps();
            });
        }
    }

    public static function add(string $title, string $shortDescription, string $description, int $userId, bool $actived = false, string $image = '/img/post/post-no-img.png')
    {
        return Post::create([
            'title' => $title,
            'short_description' => $shortDescription,
            'description' => $description,
            'user_id' => $userId,
            'actived' => $actived,
            'image' => $image,
        ]);
    }

    public static function update(int $id, array $data)
    {
        return Post::where('id', $id)->update($data);
    }
}
