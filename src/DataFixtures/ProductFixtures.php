<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 10; $i < 20; $i++)
        {
            $product = new Product();
            $product->setName("women clothes $i");
            $product->setQuantity(10);
            $product->setPrice(100);
            $product->setThumbnail("$i.jpeg");
            $manager->persist($product);
        }

        for($i = 0; $i < 10; $i++)
        {
            $product = new Product();
            $product->setName("men clothes $i");
            $product->setQuantity(10);
            $product->setPrice(100);
            $product->setThumbnail("$i.jpeg");
            $manager->persist($product);
        }

        $manager->flush();
    }
}
