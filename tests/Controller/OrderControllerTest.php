<?php

namespace App\Tests\Controller;

use App\DataFixtures\ProductFixtures;
use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testAccessDenyOrderForGuest()
    {
        $client = static::createClient();
        $client->request('POST', '/order/submit');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testSubmitEmptyOrder(): void
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => UserFixtures::users[0]["username"],
            'PHP_AUTH_PW'   => UserFixtures::users[0]["password"],
        ]);
        $client->request('POST', '/order/submit');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testSubmitOrder(): void
    {
        $productId = 10;
        $productData = ProductFixtures::Products[$productId];

        $client = static::createClient([], [
            'PHP_AUTH_USER' => UserFixtures::users[0]["username"],
            'PHP_AUTH_PW'   => UserFixtures::users[0]["password"],
        ]);

        $client->request('POST', '/cart/push', ['id' => $productId]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('POST', '/order/submit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $res = json_decode($client->getResponse()->getContent());
        $client->request('GET', '/order/' . $res->id);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsStringIgnoringCase($productData["name"], $client->getResponse()->getContent());

    }


}
