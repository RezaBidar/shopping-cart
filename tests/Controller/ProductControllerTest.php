<?php
namespace App\Tests\Controller;

use App\Controller\ProductController;
use App\DataFixtures\ProductFixtures;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ProductControllerTest extends WebTestCase
{

    public function testAccessProductsForGuest()
    {
        $client = static::createClient();
        $client->request('GET', '/products');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSearchProductList()
    {
        $kernel = self::bootKernel();
        /** @var SerializerInterface $serializer */
        $serializer = $kernel->getContainer()->get('serializer');

        //fake data
        $data = ProductFixtures::Products[1];
        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setQuantity($data['quantity']);
        $product->setId(1);
        $product->setThumbnail("1.jpeg");

        //mock repo
        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->expects($this->any())
            ->method('findByName')
            ->willReturn(array([$product]));

        //fake request
        $request = $request = Request::create('/products', 'GET', ['name' => 'fake name']);

        $productController = new ProductController($productRepository, $serializer);
        $res = $productController->search($request);

        $this->assertStringContainsStringIgnoringCase($product->getName(), $res->getContent());

    }

}