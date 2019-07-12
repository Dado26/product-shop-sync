<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    public function test_login_user_that_does_not_exist()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login');
            $browser->type('email', 'unknown@mail.com');
            $browser->type('password', 'secret');
            $browser->press('Login');
            $browser->assertPathIs('/login');
            $browser->assertSee('Wrong email or password');
        });
    }

    public function test_login_user_that_exists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login');
            $browser->type('email', 'john@mail.com');
            $browser->type('password', 'asdasd');
            $browser->press('Login');
            $browser->assertSee('John Doe');
            $browser->assertAuthenticated();
        });
    }
}
