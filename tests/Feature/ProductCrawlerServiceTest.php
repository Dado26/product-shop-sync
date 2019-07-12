<?php

namespace Tests\Feature;

use App\Services\ProductCrawlerService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Site;

class ProductCrawlerServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Services\ProductCrawlerService
     */
    private $crawler;

    /**
     * @var string
     */
    private $url;

    /**
     * ProductCrawlerServiceTest setup
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->crawler = new ProductCrawlerService();
        $this->url     = route('test.product');
        
        $this->seed('UsersTableSeeder');
        $this->seed('CrawlerTestDataSeeder');
    }

    public function test_crawler_should_return_products_title()
    {
        $this->crawler->handle($this->url);

        $this->assertEquals('Lampa za insekte', $this->crawler->getTitle());
    }

    public function test_crawler_should_return_products_description()
    {
        $this->crawler->handle($this->url);

        $this->assertEquals(
            'Napravljena specijalno za uništavanje letećih štetnih insekata.',
            //'Napravljena specijalno za uništavanje letećih štetnih insekata.',
            $this->crawler->getDescription()
        );
    }

    public function test_crawler_should_return_specifications()
    {
        $this->crawler->handle($this->url);

        $expected = '<table>
                        <tr>
                            <td>Brend</td>
                            <td>MITEA</td>
                        </tr>
                        <tr>
                            <td>Namena</td>
                            <td>Za insekte</td>
                        </tr>
                    </table>';

        // remove white space
        $expected       = preg_replace('/\s+/', '', $expected);
        $specifications = preg_replace('/\s+/', '', $this->crawler->getSpecifications());

        // check results
        $this->assertEquals($expected, $specifications);
    }

    public function test_crawler_should_return_products_url()
    {
        $this->crawler->handle($this->url);

        $this->assertEquals($this->url, $this->crawler->getUrl());
    }

    public function test_crawler_should_return_that_the_product_is_in_stock()
    {
        $this->crawler->handle($this->url);

        $this->assertTrue($this->crawler->getInStock());
    }

    public function test_crawler_should_return_if_the_product_is_in_stock()
    {
        $this->crawler->handle($this->url);

        $this->assertTrue($this->crawler->getInStock());
    }

    public function test_crawler_should_return_product_variants()
    {
        $this->crawler->handle($this->url);

        $this->assertEquals(['Blue', 'White', 'Black'], $this->crawler->getVariants());
    }

    public function test_crawler_should_return_product_images()
    {
        $this->crawler->handle($this->url);

        $expected = [
            'http://www.elementa.rs/images/products/57562/original/1.jpg',         
            'http://www.elementa.rs/images/products/57562/original/2.jpg',          
            'http://www.elementa.rs/images/products/57562/original/3.jpg',
        ];

        $this->assertEquals($expected, $this->crawler->getImages());
    }

    public function test_crawler_should_return_site_that_matched_with_product_url()
    {
        $expectedSite = Site::where('name', 'ProductSync')->first();

        $this->crawler->handle($this->url);

        $this->assertEquals($expectedSite->id, $this->crawler->getSite()->id);
    }

    public function test_crawler_should_return_product_price()
    {
        $this->crawler->handle($this->url);

        $this->assertEquals(1599.00, $this->crawler->getPrice());
    }
}
