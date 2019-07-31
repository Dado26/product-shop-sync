<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\Site;
use App\Models\Product;
use App\Jobs\ProductImportJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductImportJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('UsersTableSeeder');
        $this->seed('CrawlerTestDataSeeder');
    }

    public function test_product_import_by_url_and_category()
    {
        $productUrl = route('test.product');
        $category   = 1;

        $site = tap(Site::where('name', 'ProductSync')->first())->update([
            'price_modification' => 0,
        ]);

        ProductImportJob::dispatchNow($productUrl, $category);

        $product = Product::latest()->first();

        // check if all product data was imported
        $this->assertDatabaseHas('products', [
            'title'       => 'Lampa za insekte',
            'description' => 'Napravljena specijalno za uništavanje letećih štetnih insekata.',
            'status'      => Product::STATUS_AVAILABLE,
            'url'         => $productUrl,
            'site_id'     => $site->id,
        ]);

        $this->assertEquals(
            '<table><tr><td>Brend</td><td>MITEA</td></tr><tr><td>Namena</td><td>Zainsekte</td></tr></table>',
            preg_replace('/\s+/', '', $product->specifications)
        );

        // check if all variants were imported
        foreach (['Blue', 'White', 'Black'] as $variantName) {
            $this->assertDatabaseHas('variants', [
                'product_id' => $product->id,
                'name'       => $variantName,
                'price'      => '1899.00',
            ]);
        }

        // check if all images are imported
        foreach ([1, 2, 3] as $imageName) {
            $this->assertDatabaseHas('product_images', [
                'product_id' => $product->id,
                'source'     => "http://www.elementa.rs/images/products/57562/original/{$imageName}.jpg",
            ]);
        }
    }
}
