<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class RoleUserRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('role_user')) {
            Capsule::schema()->create('role_user', function ($table) {
                $table->integer('user_id');
                $table->integer('role_id');
                $table->timestamps();
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