<?php
namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{

    public function testShowCartItems()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john_doe',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $client->request('GET', '/cart');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddToCart()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john_doe',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $client->request('POST', '/cart', ['product_id', 1]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}