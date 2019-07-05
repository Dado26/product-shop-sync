<?php

namespace Tests\Browser;

use App\User;
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
            $browser->type('search', '154');
            $browser->press('Go!');
            $browser->assertPathIs('/products');
            $browser->assertSee('154');
        });
    }

    public function testSearchByTitle(){
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
