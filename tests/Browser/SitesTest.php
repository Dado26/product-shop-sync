<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\User;

class SitesTest extends DuskTestCase
{

    /**
     * Test if Page loads
     */
    public function testIfPageLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites');
            $browser->assertSee('Sites');
        });
    }

    /**
     * Test if the warning message pops up when creating new site
     */
    public function testIfTheWarningMessagePopsUpWhenCreatingSite() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites/create');
            $browser->press('Save');
            $browser->assertPathIs('/sites/create');
            $browser->assertSee('The name field is required.');
            $browser->assertSee('The url field is required.');
            $browser->assertSee('The email field is required.');
            $browser->assertSee('The title field is required.');
            $browser->assertSee('The description field is required.');
            $browser->assertSee('The price field is required.');
            $browser->assertSee('The in_stock field is required.');
            $browser->assertSee('The in_stock_value field is required.');
            $browser->assertSee('The images field is required.');
        });
    }

    /**
     * Test if url format is valid
     */
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

    /**
     * Test if email adress is valid
     */
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

    /**
     * Test if url format is valid when edited
     */
    public function testIfUrlFormatIsValidWhenEdited()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites');
            $browser->clickLink('Edit');
            $browser->visit('/sites/20/edit');
            $browser->type('sites[url]', 'url');
            $browser->press('Save');
            $browser->assertPathIs('/sites/20/edit');
            $browser->assertSee('The url format is invalid.');
        });
    }

    /**
     * Test if email adress is valid when edited
     */
    public function testIfEmailAdressIsValidWhenEdited()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites/20/edit');
            $browser->type('sites[email]', 'zryan');
            $browser->press('Save');
            $browser->assertPathIs('/sites/20/edit');
            $browser->assertSee('The email must be a valid email address.');
        });
    }

    /**
     * Test if message pops up when edited
     */
    public function testIfMessagePopsUpWhenEdited()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/sites/33/edit');
            $browser->press('Save');
            $browser->assertPathIs('/sites');
            $browser->assertSee('You have succesfully update site');
        });
    }

}
