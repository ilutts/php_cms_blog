<?php

namespace App\Service;

use App\Model\UnregisteredSubscriber;
use App\Model\UnregisteredSubscriberRepository;
use App\Model\User;

class SubscriberServices
{
    private string $email;
    private string $success;
    private array $error = [];

    public static function get()
    {
        $countRegisteredUsers = (int)User::count();
        $countUnregisteredUsers = (int)UnregisteredSubscriber::count();

        $maxCountUsers = $countRegisteredUsers > $countUnregisteredUsers ? $countRegisteredUsers : $countUnregisteredUsers;

        $maxItemOnPage = $_GET['quantity'] ?? 20;

        if ($maxItemOnPage === 'all') {
            $maxItemOnPage = $maxCountUsers;
        } else {
            $maxItemOnPage  = (int)$maxItemOnPage;
        }

        $skipPosts = 0;

        if (!empty($_GET['page']) && $_GET['page'] > 1) {
            $page = (int)$_GET['page'];
            $skipPosts = $page * $maxItemOnPage - $maxItemOnPage;
        }

        $users = [
            'registeredUsers' => User::select('id', 'email', 'name', 'created_at', 'updated_at', 'signed')->skip($skipPosts)->take($maxItemOnPage)->get(),
            'unregisteredUsers' => UnregisteredSubscriber::skip($skipPosts)->take($maxItemOnPage)->get(),
            'countPages' => ceil($maxCountUsers / $maxItemOnPage)
        ];

        return $users;
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

    public function newUnregistered()
    {
        $this->email = htmlspecialchars($_POST['email']);

        if ($this->validate()) {
            $unregisteredSubscriber = UnregisteredSubscriberRepository::add($this->email);

            if ($unregisteredSubscriber->wasRecentlyCreated) {
                $this->success = 'Спасибо за подписку!';
            } else {
                $this->success = 'Вы уже подписаны!';
            }
        }
    }

    private function validate(): bool
    {
        $validateServices = new ValidateServices();
        $validateServices->checkEmail($this->email);

        if ($validateServices->getError()) {
            $this->error = $validateServices->getError();
            return false;
        }

        return true;
    }
}
