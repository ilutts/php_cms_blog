<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class AdminMenuRepository extends Repository
{
  public static function createTable()
  {
    if (!Capsule::schema()->hasTable('admin_menu')) {
      Capsule::schema()->create('admin_menu', function ($table) {
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
    AdminMenu::firstOrCreate([
      'name' => $name,
      'title' => $title,
      'url' => $url,
    ]);
  }
}
