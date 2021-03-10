<?php

namespace App\EventSubscriber;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderSubscriber implements EventSubscriber
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {

        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    /**
     * cleanup shopping cart after submit an order
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if(!$entity instanceof Order)
        {
            return;
        }

        if (!$token = $this->tokenStorage->getToken())
        {
            return ;
        }

        if (!$token->isAuthenticated()) {
            return ;
        }

        /** @var User $user */
        $user = $token->getUser();

        $this->shoppingCartCleanUp($user);
        $this->decreaseProductsQuantity($user);

        $this->entityManager->flush();
        return;
    }

    private function shoppingCartCleanUp(User $user)
    {
        $cartItems = $user->getCartItems();
        foreach($cartItems as $item)
        {
            $this->entityManager->remove($item);
        }
    }

    private function decreaseProductsQuantity(User $user)
    {
        $cartItems = $user->getCartItems();
        foreach($cartItems as $item)
        {
            $product = $item->getProduct();
            $newQuantity = $product->getQuantity() - $item->getQuantity();
            $product->setQuantity($newQuantity);
        }
    }


}
