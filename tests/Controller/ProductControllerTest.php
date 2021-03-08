<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testProductList()
    {
        $client = static::createClient();
        $client->request('GET', '/products');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}