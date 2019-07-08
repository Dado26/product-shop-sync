<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AuthTest extends DuskTestCase
{
    public function testGuestCantAccessAuthPages()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/users');
            $browser->assertPathIs('/login');
        });
    }

    public function testAuthUserCantAccessLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/login');
            $browser->assertPathIs('/products');
        });
    }

    public function testGuestCanAccessTelescope()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/debug');
            $browser->assertPathIs( '/login');
        });
    }

    public function testAuthUserCanAccessTelescope()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/debug');
            $browser->assertPathIs( '/debug/requests');
        });
    }

    public function testGuestCanAccessHorizon()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit( '/horizon');
            $browser->assertPathIs('/login');
        });
    }

    public function testAuthUserCanAccessHorizon()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit( '/horizon');
            $browser->assertPathIs( '/horizon/dashboard');
        });
    }
}
