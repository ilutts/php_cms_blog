<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class CommentRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('comments')) {
            Capsule::schema()->create('comments', function ($table) {
                $table->increments('id');
                $table->string('title');
                $table->longText('text');
                $table->integer('post_id');
                $table->integer('user_id');
                $table->timestamps();
            });
        }
    }

    public static function add(string $title, string $text, int $postId, int $userId)
    {
        Comment::firstOrCreate([
            'title' => $title,
            'text' => $text,
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
    }
}