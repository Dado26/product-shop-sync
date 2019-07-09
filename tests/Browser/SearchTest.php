<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;


class SearchTest extends DuskTestCase
{
    public function testSearchById()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->type('search', '20');
            $browser->press('Go!');
            $browser->assertPathIs('/products');
            $browser->assertSee('20');
        });
    }

    public function testSearchByTitle()
    {
        $this->browse(function (Browser $browser) {
            Product::first()->update(['title' => 'Headphones']);

            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->type('search', 'Head');
            $browser->press('Go!');
            $browser->assertPathIs('/products');
            $browser->assertSee('Headphones');
        });
    }
}
