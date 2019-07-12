<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LogOutTest extends DuskTestCase
{
    public function test_log_out()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/users');
            $browser->clickLink('John Doe');
            $browser->clickLink('Logout');
            $browser->assertPathIs('/login');
            $browser->assertGuest();
        });
    }
}
