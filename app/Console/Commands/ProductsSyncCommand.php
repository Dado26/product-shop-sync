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
    protected $signature = 'sync:products {--unavailable}';

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
        $products = Product::query();

        if ($this->option('unavailable')) {
            // UNAVAILABLE
            $products->where('status', Product::STATUS_UNAVAILABLE)
                     ->where('queued_at', '<=', now()->subDays(5))
                     ->where('synced_at', '>=', now()->subMonths(6))
                     ->where(function ($query) {
                         $query->where('queued_at', '<=', now()->subHours(1))
                               ->orWhere('queued_at', null);
                     });
        } else {
            // AVAILABLE
            $products->where('status', Product::STATUS_AVAILABLE)
                     ->where('synced_at', '<=', now()->subHours(24))
                     ->where(function ($query) {
                         $query->where('queued_at', '<=', now()->subHours(1))
                               ->orWhere('queued_at', null);
                     })
                     ->limit(100);
        }

        $jobs = [];

        foreach ($products->get() as $product) {
            $product->update(['queued_at' => now()]);

            $jobs[] = new ProductSyncJob($product);
        }

        Queue::bulk($jobs, null, ProductSyncJob::QUEUE_NAME);

        $this->info('Queued jobs:'.count($jobs));
    }
}
