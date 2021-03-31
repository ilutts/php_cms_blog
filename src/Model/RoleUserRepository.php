<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class RoleUserRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('role_user')) {
            Capsule::schema()->create('role_user', function ($table) {
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->integer('role_id')->unsigned();
                $table->foreign('role_id')->references('id')->on('roles');
                $table->timestamps();

                $table->unique(['user_id', 'role_id']);
            });
        }
    }

    public static function add(int $userId, int $roleId)
    {
        RoleUser::firstOrCreate([
            'user_id' => $userId,
            'role_id' => $roleId
        ]);
    }
}