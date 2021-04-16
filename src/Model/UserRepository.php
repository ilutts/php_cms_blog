<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class UserRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('users')) {
            Capsule::schema()->create('users', function ($table) {
                $table->increments('id');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('name');
                $table->string('about')->nullable();
                $table->string('image')->default('/img/user/no-avatar.png');
                $table->boolean('signed')->default(0);
                $table->timestamps();
            });
        }
    }

    public static function add(string $email, string $password, string $name)
    {
        return User::firstOrCreate(
            ['email' => $email],
            ['password' => $password, 'name' => $name]
        );
    }

    public static function createLinkToRole()
    {
        if (!Capsule::schema()->hasTable('role_user')) {
            Capsule::schema()->create('role_user', function ($table) {
                $table->integer('user_id');
                $table->integer('role_id');
            });
        }
    }

    public static function update(int $id, array $data)
    {
        return User::where('id', '=', $id)->update($data);
    }
}
