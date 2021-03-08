<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CartController provides all shopping cart features
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
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