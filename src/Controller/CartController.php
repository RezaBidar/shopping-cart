<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController {

    /**
     * @Route("/cart")
     */
    public function index(){
        return $this->json(json_decode('{"items": []}'));
    }

}