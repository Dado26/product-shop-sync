<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\BrowserKit\CookieJar;

class TestLoginController extends Controller
{
    public function get(Request $request)
    {
        $client = new Client();
        $client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:57.0) Gecko/20100101 Firefox/57.0');
        $url = 'http://manna.org.rs/baza/login';

        $crawler = $client->request('GET', $url);

        $form = $crawler->selectButton('Prijavi me')->form();

        $crawler = $client->submit($form, ['email' => 'daniel@gmail.com', 'password' => 'asdasd']);

        $cookie = $client->getCookieJar()->get('laravel_session');

        $cookie->getExpiresTime();
        $cookie->getValue();
        dd($cookie->getExpiresTime());

        dd($client->getCookieJar()->get('laravel_session'));
        echo $crawler->html();

        //dd(get_class_methods($crawler));
    }

    public function testCookieLogin()
    {
        $cookie2   = 'eyJpdiI6Ik40bG1uRWZcL0treEdNRjcxaVkxcVNBPT0iLCJ2YWx1ZSI6Imp3OW9YZVwvd0s1MjNPYlR5Qkk3K1BcL2FJVWFiQlVBODFQd2ZaTHJLSEVOR1NRY0VkMnBmTFZJcjRwTTl3TjhHWEo4TDJwemUyWnVmTEtheHJZb2N6dnc9PSIsIm1hYyI6IjllMjFiOWVjZmNhNGZlNzgzYmQ4MGYxYWVlZTNmMDYxMTczYTE4ZWY3OGUxZGY4MjczNjhhMTcwMDhkOTJkZGEifQ==';
        $cookie    = new Cookie('laravel_session', $cookie2, strtotime('+1 day'));
        $cookieJar = new CookieJar();
        $cookieJar->set($cookie);

        $client = new Client([], null, $cookieJar);
        $client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:57.0) Gecko/20100101 Firefox/57.0');
        $url = 'http://manna.org.rs/baza';

        $crawler = $client->request('GET', $url);

        echo $crawler->html();
    }
}
