<?php
namespace App\Controller;

use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ProductController extends BaseController
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products", name="product_search")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $name = $request->query->get('name');
        $products = ($name) ? $this->productRepository->findByName($name): [];

        return $this->toJsonResponse($products);
    }

}