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
                $table->longText('text');
                $table->integer('post_id')->unsigned();
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->boolean('approved')->default(0);
                $table->timestamps();
            });
        }
    }

    public static function add(string $text, int $postId, int $userId, bool $approved = false)
    {
        Comment::firstOrCreate([
            'text' => $text,
            'post_id' => $postId,
            'user_id' => $userId,
            'approved' => $approved,
        ]);
    }

    public static function update(int $id, array $data)
    {
        Comment::where('id', $id)->update($data);
    }

    public static function delete(int $id)
    {
        return Comment::destroy($id);
    }
}
