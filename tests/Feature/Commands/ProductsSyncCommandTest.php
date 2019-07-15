<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use App\Models\Site;
use App\Models\Product;
use App\Jobs\ProductSyncJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsSyncCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_command_dispatches_products_that_have_been_synced_more_than_24_hours_ago()
    {
        Queue::fake();

        // prepare data
        $site = factory(Site::class)->create();

        $shouldSkip  = factory(Product::class)->create(['synced_at' => now()->subHours(4), 'site_id' => $site->id]);
        $shouldQueue = factory(Product::class)->create(['synced_at' => now()->subHours(25), 'site_id' => $site->id]);

        // run command
        $this->artisan('sync:products');

        // test results
        Queue::assertPushed(ProductSyncJob::class, function ($job) use ($shouldQueue) {
            return $job->product->id === $shouldQueue->id;
        });

        Queue::assertNotPushed(ProductSyncJob::class, function ($job) use ($shouldSkip) {
            return $job->product->id === $shouldSkip->id;
        });
    }
}
