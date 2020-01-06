<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ShopProduct;
use App\Models\Site;
use Illuminate\Console\Command;

class DeleteSiteProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:delete-all-products {--site-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all products by site id';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $site = Site::findOrFail($this->option('site-id'));

        $products = Product::where('site_id', $site->id)
                           ->where('status', '!=', Product::STATUS_DELETED)
                           ->get();

        $productsCount = count($products);

        $this->info("This action will delete {$productsCount} products from {$site->name} site");

        if (!$this->confirm('Are you sure? This action cannot be undone!')) {
            $this->line('Action cancelled');
            return;
        }

        $bar = $this->output->createProgressBar($productsCount);

        $products->each(function (Product $product) use ($bar) {
            ShopProduct::where('product_id', $product->shop_product_id)->update(['status' => 0]);

            $product->update(['status' => Product::STATUS_DELETED]);
            $product->delete(); // soft delete

            $bar->advance();
        });

        $bar->finish();
    }
}
