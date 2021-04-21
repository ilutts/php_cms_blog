<?php

namespace App\Service;

use App\Config;
use App\Model\Post;

class MailServices
{
    private string $title;
    private string $shortDescription;
    private string $link;

    public function __construct(Post $post)
    {
        $this->title = $post->title;
        $this->shortDescription = $post->short_description;
        $this->link = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/post/' . $post->id;
    }

    public function send()
    {

        if (!Config::getInstance()->get('cms.mailing_list')) {
            return false;
        }

        $subscriber = SubscriberServices::getForMailing();

        foreach ($subscriber['unregistered'] as $user) {
            $this->sendMailForUser($user, 'unreg');
        }

        foreach ($subscriber['registered'] as $user) {
            $this->sendMailForUser($user, 'reg');
        }
    }

    private function createMailBody(string $footerLink): string
    {
        $title = 'На сайте добавлена новая запись: ' . $this->title;
        $body = 'Новая статья: ' . $this->title . ',' . PHP_EOL . $this->shortDescription . PHP_EOL . '<a href="' . $this->link . '">Читать</a>';
        $footer = '-------' . PHP_EOL . '<a href="' . $footerLink . '">Отписаться от рассылки</a>';

        return $title . PHP_EOL . $body . PHP_EOL . $footer;
    }

    private function createMailForUser($user, string $body): string
    {
        return date('Y-m-d H:i:s') . ' Отправка письма - ' . $user->email . PHP_EOL . $body . PHP_EOL . PHP_EOL;
    }

    private function createUnsubscribeLink(int $userId, string $userType): string
    {
        return ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/unsubscribe/' . $userType . '/' . $userId;
    }

    private function sendMailForUser($user, string $userType = 'reg')
    {
        $unsubscribeLink = $this->createUnsubscribeLink($user->id, $userType);
        $body = $this->createMailBody($unsubscribeLink);
        $email = $this->createMailForUser($user, $body);

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_mail.txt', $email, FILE_APPEND);
    }
}
