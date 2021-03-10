<?php
namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends BaseController
{

    private $productRepository;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ProductRepository $productRepository, SerializerInterface $serializer)
    {
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
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

        return $this->toJsonResponse($products, $this->serializer);
    }

}