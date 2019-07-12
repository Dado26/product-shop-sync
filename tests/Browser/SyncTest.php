<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;
use App\Models\Variant;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;


class SearchTest extends DuskTestCase
{
    public function testSynchronizedPrice()
    {
        $this->browse(function (Browser $browser) {
            Variant::where('product_id', '114')->update(['price' => '1,590.00 din']);
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->press('Sync');
            $browser->assertPathIs('/products');
            //$browser->assertSee('Your product is being synchronized');
            $browser->assertSee('1,595.00 din');
        }); 
    }
}
