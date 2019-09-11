<?php

namespace App\Services;

use Goutte\Client;
use App\Models\Site;

class LoginCrawlerService
{
    public static function getCookie(?Site $site)
    {
        if (empty($site->username) && empty($site->password)) {
            return null;
        }

        if (!$site->session->expired()) {
            return $site->session->value;
        }

        return self::getFreshCookie($site);
    }

    public static function getFreshCookie(Site $site)
    {
        // login
        $client = new Client();
        $client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:57.0) Gecko/20100101 Firefox/57.0');

        $crawler = $client->request('GET', $site->login_url);

        $form = $crawler->selectButton($site->login_button_text)->form();

        $crawler = $client->submit($form, [$site->username_input_field => $site->username, $site->password_input_field =>  $site->password]);

        // save new session value and expiration timestamp

        $cookie = $client->getCookieJar()->get($site->session_name);

        $expires = $cookie->getExpiresTime();
        $value   = $cookie->getValue();

        $site->session()->updateOrCreate(['site_id' => $site->id], [
            'value'      => $value,
            'expires_at' => $expires,
        ]);
        // return new cookie
        return $value;
    }
}
