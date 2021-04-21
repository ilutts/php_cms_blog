<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class RoleRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('roles')) {
            Capsule::schema()->create('roles', function ($table) {
                $table->increments('id');
                $table->string('name')->uniqui();
                $table->longText('description');
                $table->timestamps();
            });
        }
    }

    public static function add(string $name, string $description)
    {
        Role::firstOrCreate([
            'name' => $name,
            'description' => $description,
        ]);
    }
}
