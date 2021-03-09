<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testEmptyProductList()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john_doe',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $client->xmlHttpRequest('GET', '/products');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('[]', $client->getResponse()->getContent());

    }

    public function testSearchProductList()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'john_doe',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $client->request('GET', '/products', ['name' => 'men']);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotEquals('[]', $client->getResponse()->getContent());

    }

}