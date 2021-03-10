<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testSubmitOrder(): void
    {
        $client = static::createClient();
        $client->request('POST', '/order/submit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
