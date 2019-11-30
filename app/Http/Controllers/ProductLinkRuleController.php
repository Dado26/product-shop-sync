<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Models\Site;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductLinkRule;
use Illuminate\Support\Str;

class ProductLinkRuleController extends Controller
{
    public function index(Site $site)
    {
        return view('sites.productsLinks', compact('site'));
    }

    public function store(Site $site)
    {
        $param = request()->all();

        $param['site_id'] = $site->id;

        $productLink = ProductLinkRule::where('site_id', $site->id)->first();

        ProductLinkRule::updateOrCreate(['site_id' => $site->id], $param);

        if ($productLink) {
            flash('You have successfully updated rules')->success();
        } else {
            flash('You have successfully added rules')->success();
        }

        return redirect()->route('sites.index');
    }

    public function getProductsLinks(Request $request, Site $site)
    {
        $productLinks  = collect([]);
        $client        = new Client();
        $url           = $request->link;
        $filterNext    = $site->productLinks->next_page;
        $filterProduct = $site->productLinks->product_link;

        do {
            $productLinks = $productLinks->merge(
                $this->getProductLinksFromUrl($url, $client, $filterProduct)
            );

            if (empty($filterNext)) {
                break;
            }

            $nextLinkExists = $this->crawler->filter($filterNext)->count();

            if ($nextLinkExists) {
                $url = $this->crawler->filter($filterNext)->attr('href');
            }
        } while ($nextLinkExists && $url);

        $productLinks = $productLinks->transform(function ($link) use ($site) {
            return Str::startsWith($link, 'http') ? $link : $site->url.$link;
        })->unique()->reject(function ($link) {
            return Product::where('url', $link)->exists();
        });

        return view('sites.productsLinks', compact('productLinks', 'site'));
    }

    private function getProductLinksFromUrl(string $url, Client $client, $filterProduct): array
    {
        $this->crawler = $client->request('GET', $url);

        $links = [];

        $this->crawler->filter($filterProduct)->each(function ($node) use (&$links) {
            $links[] = $node->attr('href');
        });

        return $links;
    }
}
