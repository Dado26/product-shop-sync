<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Jobs\ProductSyncJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class ProductsSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all products that are older than 24 hours';

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
        $products = Product::Available()->where('synced_at', '<=', now()->subHours(24))->where('queued_at', '<=', now()->subHours(3))->get();

        $jobs = [];

        foreach ($products as $product) {
            $product->update([
                'gueued_at' => now(),
            ]);
            $jobs[] = new ProductSyncJob($product);
        }

        Queue::bulk($jobs);

        $this->info('Queued jobs:' . count($jobs));
    }
}
