<?php

namespace Tests\Browser;

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
            $browser->visit('/products');
            $browser->type('search', 'nemo');
            $browser->press('Go!');
            $browser->assertPathIs('/products');
        });
    }

}
