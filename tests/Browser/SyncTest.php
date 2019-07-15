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
        $product = factory(Product::class)->create([
            'site_id' => Site::where('name', 'ProductSync')->first()->id,
            'url'     => route('test.product'),
        ]);

        factory(Variant::class)->create([
            'product_id' => $product->id,
            'price'      => 1590,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->click('.users-list-actions:first-child button');
            $browser->assertPathIs('/products');
            $browser->assertSee('Your product is being synchronized');
            $browser->assertSee('1,595.00 din');
        });
    }
}
