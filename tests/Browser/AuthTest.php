<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AuthTest extends DuskTestCase
{
    public function test_guest_cant_access_auth_pages()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/users');
            $browser->assertPathIs('/login');
        });
    }

    public function test_auth_user_cant_access_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/login');
            $browser->assertPathIs('/products');
        });
    }

    public function test_guest_can_access_telescope()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/debug');
            $browser->assertPathIs('/login');
        });
    }

    public function test_auth_user_can_access_telescope()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/debug');
            $browser->assertPathIs('/debug/requests');
        });
    }

    public function test_guest_can_access_horizon()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/horizon');
            $browser->assertPathIs('/login');
        });
    }

    public function test_auth_user_can_access_horizon()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/horizon');
            $browser->assertPathIs('/horizon/dashboard');
        });
    }
}
