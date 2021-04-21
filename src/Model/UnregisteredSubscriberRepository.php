<?php

namespace App\Model;

use \Illuminate\Database\Capsule\Manager as Capsule;

class UnregisteredSubscriberRepository extends Repository
{
    public static function createTable()
    {
        if (!Capsule::schema()->hasTable('unregistered_subscribers')) {
            Capsule::schema()->create('unregistered_subscribers', function ($table) {
                $table->increments('id');
                $table->string('email')->unique();
                $table->boolean('signed')->default(1);
                $table->timestamps();
            });
        }
    }

    public static function add(string $email)
    {
        return UnregisteredSubscriber::firstOrCreate([
            'email' => $email
        ]);
    }

    public static function delete(string $email)
    {
        UnregisteredSubscriber::where('email', $email)->delete();
    }

    public static function update(int $id, array $data)
    {
        UnregisteredSubscriber::where('id', $id)->update($data);
    }
}
