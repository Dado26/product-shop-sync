<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\Product;
use App\Models\Variant;
use App\Models\ShopProduct;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\ShopProductDescription;

class ForceDeleteProductsWithSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:force-delete-all-products-with-site {--site-id=}';
    /**
     * The console command description.
     *
     * @var string
     */  
    protected $description = 'Permanently delete products and their site';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $site = Site::findOrFail($this->option('site-id'));

        $products = Product::where('site_id', $site->id)->get();

        $productsCount = count($products);

        $this->info("This action will permanently delete {$productsCount} products and {$site->name} site");

        if (!$this->confirm('Are you sure? This action cannot be undone!')) {
            $this->line('Action cancelled');
            return;
        }

        $bar = $this->output->createProgressBar($productsCount);

        $products->each(function (Product $product) use ($bar) {
            $order = DB::connection('shop')->table('order_product')->where('product_id', $product->shop_product_id)->first();         
            if (!$order) {
                ShopProduct::where('product_id', $product->shop_product_id)->delete();
                ShopProductDescription::where('product_id', $product->shop_product_id)->delete();
                DB::connection('shop')->table('product_image')->where('product_id', $product->shop_product_id)->delete();             
            }
            $product->productImages()->each(function(ProductImage $image){
                $image->delete();
            });

            $product->variants()->each(function(Variant $variant){
                $variant->forceDelete();
            });

            $product->forceDelete();
           
            $bar->advance();
        });
          
            $site->delete();
        
            $bar->finish();
    }
    
}
