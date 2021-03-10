<?php
namespace App\Tests\Controller;

use App\DataFixtures\ProductFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{

    public function testAccessForGuest()
    {
        $client = static::createClient();
        $client->request('GET', '/cart');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testShoppingCart()
    {
        $productId = 10;
        $productData = ProductFixtures::Products[$productId];
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john_doe',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $client->request('POST', '/cart/push', ['id' => $productId]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/cart');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsStringIgnoringCase($productData["name"], $client->getResponse()->getContent());

        $client->request('POST', '/cart/pop', ['id' => $productId]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/cart');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringNotContainsStringIgnoringCase($productData["name"], $client->getResponse()->getContent());
    }


}