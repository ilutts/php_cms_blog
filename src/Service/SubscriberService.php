<?php

namespace App\Service;

use App\Model\UnregisteredSubscriber;
use App\Model\UnregisteredSubscriberRepository;
use App\Model\User;

class SubscriberService
{
    private string $success;
    private array $error = [];

    public static function getUnregisteredUsers(int $numberSkipItems, int $maxItemsOnPage)
    {
        return UnregisteredSubscriber::skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }

    public static function getRegisteredUsers(int $numberSkipItems, int $maxItemsOnPage)
    {
        return User::select('id', 'email', 'name', 'created_at', 'updated_at', 'signed')->skip($numberSkipItems)->take($maxItemsOnPage)->get();
    }

    public static function getForMailing()
    {
        return [
            'registered' => User::select('id', 'email')->where('signed', 1)->get(),
            'unregistered' => UnregisteredSubscriber::select('id', 'email')->where('signed', 1)->get(),
        ];
    }

    public function getError()
    {
        return $this->error;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function newUnregistered(string $email)
    {
        $email = strip_tags($email);

        if ($this->validate($email)) {
            $unregisteredSubscriber = UnregisteredSubscriberRepository::add($email);

            if ($unregisteredSubscriber->wasRecentlyCreated) {
                $this->success = 'Спасибо за подписку!';
            } else {
                $this->success = 'Вы уже подписаны!';
            }
        }
    }

    private function validate(string $email): bool
    {
        $validateServices = new ValidateService();
        $validateServices->checkEmail($email);

        if ($validateServices->getError()) {
            $this->error = $validateServices->getError();
            return false;
        }

        return true;
    }
}
