<?php

namespace App\Console\Commands\Elementa;

use Goutte\Client;
use App\Models\Site;
use App\Models\Product;
use App\Models\ShopProduct;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Helpers\SiteUrlParser;
use Illuminate\Console\Command;
use App\Helpers\PriceCalculator;
use JD\Cloudder\Facades\Cloudder;
use App\Jobs\TransferUpdateProductJob;

class ElementaFetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:elementaProducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all products from elementa';

    protected $num;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->num = 0;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.elementa.rs/index/product-list-xml-mpswpifmxls');

        $crawler->filter('product')->each(function ($node) {
            $title = $node->filter('naziv')->text();
            $description = $node->filter('opis')->text();
            $price = $node->filter('cena')->text();
            $sku = $node->filter('textId')->text();

            $images = $node->filter('slika')->each(function ($node2) {
                return $node2->text();
            });

            $specificationTableHtml = $this->getSpecificationTable($node);

            //dd($specificationTableHtml);

            // $specifications = implode(", ",$attributes);;

            $numId = $node->filter('numId')->text();

            $slug = Str::slug($title, '-');

            $url = "https://www.elementa.rs/proizvod/$numId/$slug";

            echo 'Searching for url: ' . $url;

            $product = Product::where('url', 'LIKE', "%/proizvod/{$numId}/{$slug}%")->first();

            //$site = SiteUrlParser::getSite($url);

            if ($product) {
                dump('1 ' . $product->synced_at);
                $updated = $product->update([
                    'title'          => $title,
                    'description'    => $description,
                    'specifications' => $specificationTableHtml,
                    'sku'            => $sku,
                    'synced_at'      => now(),
                    'status'         => Product::STATUS_AVAILABLE,
                ]);

                // update existing variants
                $product->variants()->first()->update([
                    'price' => PriceCalculator::modifyByPercent(
                        $price,
                        $product->site->price_modification,
                        $product->site->tax_percent
                    ),
                ]);

                //TransferUpdateProductJob::dispatchNow($product);//->onQueue(TransferUpdateProductJob::QUEUE_NAME);
                dump('2 ' . $product->fresh()->synced_at);
                echo ' - ' . ($updated ? 'Updated' : 'FAILED TO UPDATE!') . PHP_EOL;

                $this->num = $this->num + 1;
            } else {
                echo ' - NOT FOUND ' . PHP_EOL;
            }
        });

        $this->checkAndDeleteUnexisting();

        echo ' Synced-products: ' . $this->num . ' ';
    }

    private function checkAndDeleteUnexisting()
    {
        $timeYesterday = now()->subDay();

        $site = Site::where('id', 1)->first();

        $products = $site->products()->where('synced_at', '<', $timeYesterday)->get();

        $bar = $this->output->createProgressBar($products->count());

        $products->each(function (Product $product) use ($bar) {
            ShopProduct::where('product_id', $product->shop_product_id)->update(['status' => 0, 'date_modified' => now()]);

            $product->update(['status' => Product::STATUS_UNAVAILABLE]);

            $bar->advance();
        });

        $bar->finish();

        echo ' <-unavailable,';
    }

    private function getSpecificationTable($node)
    {
        $specificationAttributes = $node->filter('specifications > attribute')->each(function ($node2) {
            return $node2->attr('name');
        });

        $specificationValues = $node->filter('specifications > value')->each(function ($node2) {
            return $node2->html();
        });

        $specificationTableHtml = '<table>';

        for ($i=0; $i < count($specificationAttributes); $i++) {
            $specificationTableHtml .= "<tr>
                <td>{$specificationAttributes[$i]}</td>
                <td>{$specificationValues[$i]}</td>
            </tr>";
        }

        $specificationTableHtml .= '</table>';

        return $specificationTableHtml;
    }

    private function createAndUploadImages($product, $imageUrl): void
    {
        $image = ProductImage::create([
            'url'        => null,
            'source'     => $imageUrl,
            'product_id' => $product->id,
        ]);

        try {
            $cloudinaryImage = Cloudder::upload(
                $imageUrl,
                "intercool/products/{$product->id}/{$image->id}",
                ['crop' => 'fit', 'width' => 700, 'height' => 700, 'format' => 'jpg', 'quality' => 'auto:good']
                );

            $result = $cloudinaryImage->getResult();

            $image->update(['url' => $result['secure_url']]);
        } catch (Exception $e) {
            $image->delete();

            logger()->notice('Failed to upload image to cloudinary', [
                'error'      => $e->getMessage(),
                'productUrl' => $this->crawler->getUrl(),
            ]);
        }
    }
}
