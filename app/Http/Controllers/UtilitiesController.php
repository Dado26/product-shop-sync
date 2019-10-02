<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;

    public function fetchProductLinksFromCategory(Request $request)
    {
        // ELEMENTA
        $links = collect([]);
        $client = new Client();

        $url = $request->url;

        echo "<form action=''>
            <input name='url' value='{$request->url}' style='width:600px'>
            <input type='submit' value='Submit'/>
        </form>";

        if (empty($url)) {
            exit;
        }

        do {
            echo "[*] ";

            $links = $links->merge(
                $this->getProductLinksFromUrl($url, $client)
            );

            $nextLinkExists = $this->crawler->filter('.pager-right a.next')->count();

            if ($nextLinkExists) {
                $url = $this->crawler->filter('.pager-right a.next')->attr('href');
            }
        } while ($nextLinkExists);

        $links->transform(function($link) {
            return "https://elementa.rs" . $link;
        });

        echo "<hr>
        Products count: {$links->count()}<br>
        <textarea style='width:600px; height:600px'>{$links->implode("
")}</textarea>";
    }

    /**
     * @param  string  $url
     * @param  \Goutte\Client  $client
     *
     * @return array
     */
    private function getProductLinksFromUrl(string $url, Client $client): array
    {
        $this->crawler = $client->request('GET', $url);

        $this->crawler->filter('.products a.img-product')->each(function ($node) use (&$links) {
            $links[] = $node->attr('href');
        });

        return $links;
    }
}
