<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
     * @Route(path="/cart", name="shopping_cart")
     */
    public function index()
    {
        return $this->render('cart.html.twig');
    }

}