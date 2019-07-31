<?php

namespace Tests\Browser;

use App\Models\Site;
use App\Models\User;
use App\Models\Product;
use App\Models\Variant;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SyncTest extends DuskTestCase
{
    public function test_synchronized_price()
    {
        $site    = Site::where('name', 'ProductSync')->first();
        $site->update([
            'price_modification' => 0,
        ]);

        $product = factory(Product::class)->create([
            'site_id' => $site->id,
            'url'     => route('test.product'),
        ]);

        factory(Variant::class)->create([
            'product_id' => $product->id,
            'price'      => 1595,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->click('.users-list-actions:first-child button');
            $browser->assertPathIs('/products');
            $browser->assertSee('Your product was synchronized');
            $browser->assertSee('1,899.00 din');
        });
    }
}
