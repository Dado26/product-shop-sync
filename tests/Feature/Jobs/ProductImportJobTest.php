<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\Site;
use App\Models\Product;
use App\Jobs\ProductImportJob;

class ProductImportJobTest extends TestCase
{
    public function test_product_import_by_url_and_category()
    {
        $productUrl = route('test.product');
        $category = 'Electronics';

        ProductImportJob::dispatchNow($productUrl, $category);

        $product = Product::latest()->first();
        // dd($product->toArray());

        // check if all product data was imported
        $this->assertDatabaseHas('products', [
            'title' => 'Lampa za insekte',
            'description' => 'Napravljena specijalno za uništavanje letećih štetnih insekata.',
            'category' => $category,
            'status' => Product::STATUS_AVAILABLE,
            'url' => $productUrl,
            'site_id' => Site::where('name', 'ProductSync')->first()->id,
        ]);

        $this->assertEquals(
            '<table><tr><td>Brend</td><td>MITEA</td></tr><tr><td>Namena</td><td>Zainsekte</td></tr></table>',
            preg_replace('/\s+/', '', $product->specifications)
        );

        // check if all variants were imported
        foreach(['Blue', 'White', 'Black'] as $variantName) {
            $this->assertDatabaseHas('variants', [
                'product_id' => $product->id,
                'name' => $variantName,
                'price' => 1599,
            ]);    
        }

        // check if all images are imported
        foreach([1, 2, 3] as $imageName) {
            $this->assertDatabaseHas('product_images', [
                'product_id' => $product->id,
                'url' => "http://www.elementa.rs/images/products/57562/original/{$imageName}.jpg",
            ]);    
        }
    }
}