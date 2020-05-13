<?php

namespace App\Console\Commands\Elementa;

use App\Models\Site;
use App\Models\Product;
use App\Models\ShopProduct;
use Illuminate\Console\Command;

class SetStatusAvailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'element:setStatusAvailable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set status available to all products from elementa site';

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
        $site = Site::find(1);

        $products = $site->products;

        $bar = $this->output->createProgressBar($products->count());

        $products->each(function(Product $product) use ($bar) {
           
            ShopProduct::where('product_id', $product->shop_product_id)->update(['status' => 1, 'date_modified' => now()]);

            $product->update(['status' => Product::STATUS_AVAILABLE ]);

            $bar->advance();

       });

       $bar->finish();

    }
}
