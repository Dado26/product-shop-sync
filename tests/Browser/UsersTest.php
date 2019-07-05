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
            $browser->visit('/user/create');
            $browser->type('first_name', 'Test');
            $browser->type('last_name', 'User');
            $browser->type('email', 'asd@mail.com');
            $browser->type('password', 'asdasd');
            $browser->type('password_confirmation', 'asdasdasd');
            $browser->press('Save');
            $browser->assertPathIs('/user/create');
            $browser->assertSee('The password confirmation does not match');
            $browser->assertSee('The password must be at least 8 characters');
        });
    }

    public function testCreateUserWithEmptyFields()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/user/create');
            $browser->press('Save');
            $browser->assertPathIs('/user/create');
            $browser->assertSee('The first name must be at least 2 characters.');
            $browser->assertSee('The last name must be at least 3 characters.');
            $browser->assertSee('The email field is required.');
            $browser->assertSee('The password field is required.');
        });
    }

    public function testCreateUserWithPasswordMismatch()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/user/create');
            $browser->type('first_name', 'Altak');
            $browser->type('last_name', 'Morark');
            $browser->type('email', 'asd@mail.com');
            $browser->type('password', 'asdfghjk');
            $browser->type('password_confirmation', 'qwertyui');
            $browser->press('Save');
            $browser->assertPathIs('/user/create');
            $browser->assertSee('The password confirmation does not match.');
        });
    }

    public function testEditUserWithShortPassword()
    {
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

    public function testEditUserWithPasswordNotMatch()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/user/2/edit');
            $browser->type('password', 'sdfgsddf');
            $browser->type('password_confirmation', 'hgjkdfff');
            $browser->press('Save');
            $browser->assertPathIs('/user/2/edit');
            $browser->assertSee('The password confirmation does not match.');
        });
    }

    public function testCreateNewUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/user/create');
            $browser->type('first_name', 'test2user');
            $browser->type('last_name', 'lasttes2');
            $browser->type('email', 'test2@'.time().'.com');
            $browser->type('password', '12345678');
            $browser->type('password_confirmation', '12345678');
            $browser->press('Save');
            $browser->assertPathIs('/users');
            $browser->assertSee('You have successfully created new user');
        });
    }

    public function testEditUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1));
            $browser->visit('/user/10/edit');
            $browser->type('email', 'test222@email.com');
            $browser->type('last_name', 'lasttes222');
            $browser->type('first_name', 'test2user22');
            $browser->type('password', '123456789');
            $browser->type('password_confirmation', '123456789');
            $browser->press('Save');
            $browser->assertPathIs('/users');
            $browser->assertSee('You have successfully updated user');
        });
    }
}
