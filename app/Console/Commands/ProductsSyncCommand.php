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
    protected $signature = 'sync:products {--unavailable} {--older-than-hours=24} {--site-id=} {--limit=100} {--force}';

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

        $siteId = $this->option('site-id');
        $hours  = $this->option('older-than-hours');
        $limit  = $this->option('limit');
        $force  = $this->option('force');

        if ($this->option('unavailable')) {
            // UNAVAILABLE
            $products->where('status', Product::STATUS_UNAVAILABLE)
                     ->when(!$force, function ($query) {
                         $query->where('queued_at', '<=', now()->subDays(5))
                               ->where('synced_at', '>=', now()->subMonths(6));
                     })
                     ->when($siteId, function ($query) use ($siteId) {
                         $query->where('site_id', $siteId);
                     })
                     ->where(function ($query) {
                         $query->where('queued_at', '<=', now()->subHours(1))
                               ->orWhere('queued_at', null);
                     });
        } else {
            // AVAILABLE
            $products->where('status', Product::STATUS_AVAILABLE)
                     ->when(!$force, function ($query) use ($hours) {
                         $query->where('synced_at', '<=', now()->subHours($hours));
                     })
                     ->where(function ($query) {
                         $query->where('queued_at', '<=', now()->subHours(1))
                               ->orWhere('queued_at', null);
                     })
                     ->when($siteId, function ($query) use ($siteId) {
                         $query->where('site_id', $siteId);
                     })
                     ->limit($limit);
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
