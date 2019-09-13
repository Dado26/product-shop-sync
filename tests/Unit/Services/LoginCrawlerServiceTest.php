<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Site;
use App\Models\Product;
use App\Models\Variant;
use App\Jobs\ProductSyncJob;
use App\Services\LoginCrawlerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginCrawlerServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Site
     */
    protected $site;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('UsersTableSeeder');
        $this->seed('CrawlerTestDataSeeder');

        $this->site = Site::where('name', 'ProductSync')->first();
    }

    public function test_that_null_is_returned_when_username_or_password_is_empty()
    {
        $cookie = LoginCrawlerService::getCookie($this->site);

        $this->assertNull($cookie);
    }

    public function test_that_cookie_is_returned_if_not_expired()
    {
        $this->site->session()->create([
            'value'      => 'cookie-value',
            'expires_at' => now()->addDay(),
        ]);

        $this->site->username = 'username';
        $this->site->password = 'password';
        $this->site->save();

        $cookie = LoginCrawlerService::getCookie($this->site);

        $this->assertEquals('cookie-value', $cookie);
    }

    public function test_that_fresh_cookie_is_returned_when_previous_cookie_has_expired()
    {
        $this->site->session()->create([
            'value'      => 'cookie-value',
            'expires_at' => now(), // in model there is set time 5 minutes less from now
        ]);

        $this->site->username                          = 'john@mail.com';
        $this->site->password                          = encrypt('asdasd');
        $this->site->username_input_field              = 'email';
        $this->site->password_input_field              = 'password';
        $this->site->session_name                      = 'productsync_session';
        $this->site->login_button_text                 = 'Login';
        $this->site->login_url                         = 'http://product-sync/test/login';
        $this->site->save();

        $cookie = LoginCrawlerService::getCookie($this->site);

        $this->assertNotEquals('cookie-value', $cookie);
    }

    public function test_that_invalid_cookie_is_refreshed()
    {
        //$this->withoutExceptionHandling();

        $this->site->session()->create([
            'value'      => 'cookie-value',
            'expires_at' => now()->addDay(),
        ]);

        $this->site->username                          = 'john@mail.com';
        $this->site->password                          = encrypt('asdasd');
        $this->site->username_input_field              = 'email';
        $this->site->password_input_field              = 'password';
        $this->site->session_name                      = 'productsync_session';
        $this->site->login_button_text                 = 'Login';
        $this->site->login_url                         = 'http://product-sync/test/login';
        $this->site->auth_element_check                = '#logoutTest';
        $this->site->save();

        $cookie = LoginCrawlerService::getCookie($this->site);

        $this->site->session->update([
            'value'      => 'cookie-invalid',
        ]);

        $product = factory(Product::class)->create([
            'site_id' => $this->site->id,
            'url'     => route('test.product_auth'),
        ]);

        factory(Variant::class)->create([
            'product_id' => $product->id,
            'price'      => 1595,
        ]);

        ProductSyncJob::dispatchNow($product);

        $this->assertDatabaseMissing('sessions', ['value' => 'cookie-invalid']);
    }
}
