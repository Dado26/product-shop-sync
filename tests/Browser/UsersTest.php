<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class UsersTest extends DuskTestCase
{
    public function testCreateWithPasswordThatDoNotMatch()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/create');
            $browser->type('first_name', 'Test');
            $browser->type('last_name', 'User');
            $browser->type('email', 'asd@mail.com');
            $browser->type('password', 'asdasd');
            $browser->type('password_confirmation', 'asdasdasd');
            $browser->press('Save');
            $browser->assertPathIs('/create');
            $browser->assertSee('The password confirmation does not match');
            $browser->assertSee('The password must be at least 8 characters');
        });
    }

    public function testCreateUserWithEmptyFields(){

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/create');
            $browser->press('Save');
            $browser->assertPathIs('/create');
            $browser->assertSee('The first name must be at least 2 characters.');
            $browser->assertSee('The last name must be at least 3 characters.');
            $browser->assertSee('The email field is required.');
            $browser->assertSee('The password field is required.');
        });
    }

    public function testCreateUserWithPasswordMissmatch(){

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/create');
            $browser->type('first_name', 'Altak');
            $browser->type('last_name', 'Morark');
            $browser->type('email', 'asd@mail.com');
            $browser->type('password', 'asdfghjk');
            $browser->type('password_confirmation', 'qwertyui');
            $browser->press('Save');
            $browser->assertPathIs('/create');
            $browser->assertSee('The password confirmation does not match.');
        });
    }

    public function testEditUserWithShortPassword(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/user/7/edit');
            $browser->type('password', 'asdasd');
            $browser->type('password_confirmation', 'asdasd');
            $browser->press('Save');
            $browser->assertPathIs('/user/7/edit');
            $browser->assertSee('The password must be at least 8 characters.');
        });
    }

    public function testEditUserWithPasswordNotMatch(){

        $this->browse(function(Browser $browser) {
                $browser->loginAs(User::find(1));
                $browser->visit('/user/2/edit');
                $browser->type('password', 'sdfgsddf');
                $browser->type('password_confirmation', 'hgjkdfff');
                $browser->press('Save');
                $browser->assertPathIs('/user/2/edit');
            $browser->assertSee('The password confirmation does not match.');
        });
    }
}
