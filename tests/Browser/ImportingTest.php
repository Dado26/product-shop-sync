<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Product;

class ImportingTest extends DuskTestCase
{
    public function test_imported_url_that_was_already_imported()
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

    public function test_imported_without_url()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->press('import');
            $browser->assertPathIs('/products');
            $browser->assertSee('The url field is required.');
        });
    }

    public function test_when_single_url_is_queued_to_be_imported_successfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->type('url', 'http://product-sync/test/');

            $browser->waitUsing(1, 100, function() use ($browser) {
                // we don't want to creat categories in shop database
                // so we will create and select it with javascript
                return $browser->script("
                    var option = document.createElement('option');
                    option.text = 'Test';
                    option.value = 1;
                    
                    var select = document.querySelector('select[name=category]');
                    
                    select.appendChild(option);
                    select.selectedIndex = 0;
                ");
            });
            $browser->press('import');
            $browser->assertPathIs('/products');
            $browser->assertSee('Your product was queued successfully, it will be processed soon.');
        });
    }

    public function test_when_batch_urls_are_queued_to_be_imported_successfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/products');
            $browser->press('batch');
            $browser->type('urls', 'http://product-sync/test1/
http://product-sync/test2/');
            $browser->waitUsing(1, 100, function() use ($browser) {
                // we don't want to creat categories in shop database
                // so we will create and select it with javascript
                return $browser->script("
                    var option = document.createElement('option');
                    option.text = 'Test';
                    option.value = 1;
                    
                    var select = document.querySelector('select[name=category]');
                    
                    select.appendChild(option);
                    select.selectedIndex = 0;
                ");
            });
            $browser->press('import');
            $browser->assertPathIs('/products');
            $browser->assertSee('Your products were queued successfully, they will be processed soon.');
        });
    }
}
