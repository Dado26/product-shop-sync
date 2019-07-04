<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\User;

class SitesTest extends DuskTestCase
{
    public function testIfPageLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites');
            $browser->assertSee('Sites');
        });
    }

    public function testIfTheWarningMessagePopsUpWhenTheRequriedFieldIsEmpty() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites/create');
            $browser->press('Save');
            $browser->assertPathIs('/sites/create');
            $browser->assertSee('The name field is required.');
            $browser->assertSee('The url field is required.');
            $browser->assertSee('The email must be a valid email address.');
            $browser->assertSee('The title field is required.');
            $browser->assertSee('The description field is required.');
            $browser->assertSee('The price field is required.');
            $browser->assertSee('The in_stock field is required.');
            $browser->assertSee('The in_stock_value field is required.');
            $browser->assertSee('The images field is required.');
        });
    }

    public function testIfUrlFormatIsValid()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites/create');
            $browser->type('sites[name]', 'Voja');
            $browser->type('sites[url]', 'url');
            $browser->type('sites[email]', 'vojke@mail.com');
            $browser->type('sync_Rules[title]', 'Title');
            $browser->type('sync_Rules[description]', 'Description');
            $browser->type('sync_Rules[price]', '1');
            $browser->type('sync_Rules[in_stock]', '1');
            $browser->type('sync_Rules[in_stock_value]', '1');
            $browser->type('sync_Rules[images]', 'img.jpg');
            $browser->type('sync_Rules[variants]', 'Variants');
            $browser->press('Save');
            $browser->assertPathIs('/sites/create');
            $browser->assertSee('The url format is invalid.');
        });
    }

    public function testIfEmailAdressIsValid()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites/create');
            $browser->type('sites[name]', 'Voja');
            $browser->type('sites[url]', 'https://sirka.com/');
            $browser->type('sites[email]', 'vojkemail.com');
            $browser->type('sync_Rules[title]', 'Title');
            $browser->type('sync_Rules[description]', 'Description');
            $browser->type('sync_Rules[price]', '1');
            $browser->type('sync_Rules[in_stock]', '1');
            $browser->type('sync_Rules[in_stock_value]', '1');
            $browser->type('sync_Rules[images]', 'img.jpg');
            $browser->type('sync_Rules[variants]', 'Variants');
            $browser->press('Save');
            $browser->assertPathIs('/sites/create');
            $browser->assertSee( 'The email must be a valid email address.');
        });
    }
}
