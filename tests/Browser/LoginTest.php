<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    public function testLoginUserThatDoesNotExist()
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

    public function testLoginUserThatExists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login');
            $browser->type('email', 'john@mail.com');
            $browser->type('password', 'asdasd');
            $browser->press('Login');
            $browser->assertSee('John Doe');
        });
    }
    
}
