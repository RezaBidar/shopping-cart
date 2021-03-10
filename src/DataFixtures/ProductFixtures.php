<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    const Products = [
       1 => [
           "name" => "Gray Men Shirts",
           "quantity" => 5,
           "price" => 500,
       ],
        2 => [
            "name" => "Gray Checkered Men Shirt",
            "quantity" => 10,
            "price" => 700,
        ],
        3 => [
            "name" => "Men Gray Active wear",
            "quantity" => 2,
            "price" => 100,
        ],
        4 => [
            "name" => "Men Black Shirt",
            "quantity" => 7,
            "price" => 800,
        ],
        5 => [
            "name" => "Men Green Shirt",
            "quantity" => 11,
            "price" => 900,
        ],
        6 => [
            "name" => "Men Blue Shirt",
            "quantity" => 2,
            "price" => 1000,
        ],
        7 => [
            "name" => "Men White Shirt",
            "quantity" => 5,
            "price" => 400,
        ],
        8 => [
            "name" => "Men Black Shirt",
            "quantity" => 4,
            "price" => 100,
        ],
        9 => [
            "name" => "Men Black and White Shirt",
            "quantity" => 6,
            "price" => 500,
        ],
        10 => [
            "name" => "Men Red Shirt",
            "quantity" => 10,
            "price" => 300,
        ],
        11 => [
            "name" => "Women Green Hoodie",
            "quantity" => 20,
            "price" => 1500,
        ],
        12 => [
            "name" => "Women Fantasy T-shirt",
            "quantity" => 10,
            "price" => 200,
        ],
        13 => [
            "name" => "Women White Coat",
            "quantity" => 6,
            "price" => 400,
        ],
        14 => [
            "name" => "Women Red Jacket",
            "quantity" => 8,
            "price" => 1000,
        ],
        15 => [
            "name" => "Women Black Jacket",
            "quantity" => 10,
            "price" => 500,
        ],
        16 => [
            "name" => "Women Checkered White Jacket",
            "quantity" => 1,
            "price" => 2000,
        ],
        17 => [
            "name" => "Women Checkered Coat",
            "quantity" => 5,
            "price" => 900,
        ],
        18 => [
            "name" => "Women Orange Shirt",
            "quantity" => 11,
            "price" => 150,
        ],
        19 => [
            "name" => "Women Brown Coat",
            "quantity" => 12,
            "price" => 1450,
        ],
        20 => [
            "name" => "Women Black Coat",
            "quantity" => 10,
            "price" => 1350,
        ],

    ];
    public function load(ObjectManager $manager)
    {
        foreach(self::Products as $key => $data)
        {
            $product = new Product();
            $product->setId($key);
            $product->setName($data["name"]);
            $product->setQuantity($data["quantity"]);
            $product->setPrice($data["price"]);
            $product->setThumbnail("$key.jpeg");
            $manager->persist($product);
        }

        $manager->flush();
    }
}
