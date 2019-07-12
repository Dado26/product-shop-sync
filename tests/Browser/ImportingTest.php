<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Product;


class ImportingTest extends DuskTestCase
{
    public function testImportedUrlThatWasAlreadyImported()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->type('url', Product::first()->url);
            $browser->press('import');
            $browser->assertPathIs('/products');
            $browser->assertSee('This product was already imported');
    });
    }

    public function testImportedWithoutUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->press('import');
            $browser->assertPathIs('/products');
            $browser->assertSee('The url field is required.');
        });
    
    }

    public function testWhenImportedSuceesfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->type('url','http://product-sync/test/');
            $browser->press('import');
            $browser->assertPathIs('/products');
            $browser->assertSee('Your product was queued successfully, it will be processed soon.');
        });
    
    }


}
