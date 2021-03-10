<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    const users = [
        [
            "username" => "john_doe",
            "password" => "12345"
        ],
        [
            "username" => "a_b",
            "password" => "12345"
        ],
        [
            "username" => "j_li",
            "password" => "12345"
        ]
    ];

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::users as $userData){
            $user = new User();
            $user->setUsername($userData["username"]);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $userData["password"]));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
