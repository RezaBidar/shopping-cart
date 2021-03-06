<?php
namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\User;
use App\Repository\CartItemRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CartController provides all shopping cart features
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class CartController extends BaseController
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {

        $this->serializer = $serializer;
    }

    /**
     * @Route(path="/cart", name="shopping_cart", methods={"GET"})
     */
    public function index()
    {
        $items = $this->getUser()->getCartItems();
        return $this->render('cart.html.twig', ['items' => $items->getValues()]);
    }

    /**
     * @Route(path="/cart/push", name="add_to_cart", methods={"POST"})
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param CartItemRepository $cartItemRepository
     * @return Response
     */
    public function addToCart(Request $request, ProductRepository $productRepository, CartItemRepository $cartItemRepository)
    {
        $id = $request->get('id');
        $product = ($id) ? $productRepository->find($id): null;
        if(!$product){
            $this->addFlash('warning', 'Product not found');
            throw $this->createNotFoundException();
        }


        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $oldItem = $cartItemRepository->findOneBy(["user" => $currentUser, "product" => $product]);

        $newQuantity = $product->getQuantity() - (($oldItem)? $oldItem->getQuantity() + 1 : 1);
        if($newQuantity < 0)
        {
            $this->addFlash('warning', 'You have reached the maximum quantity available for ' . $product->getName());
            return $this->toJsonResponse($product, $this->serializer);
        }

        if($oldItem)
        {
            $oldItem->setQuantity($oldItem->getQuantity() + 1);
        }
        else
        {
            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setUser($currentUser);
            $cartItem->setQuantity(1);
            $this->getDoctrine()->getManager()->persist($cartItem);
        }

        $this->getDoctrine()->getManager()->flush();
        return $this->toJsonResponse($product, $this->serializer);
    }

    /**
     * @Route(path="/cart/pop", name="remove_from_cart", methods={"POST"})
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param CartItemRepository $cartItemRepository
     * @return Response
     */
    public function removeFromCart(Request $request, ProductRepository $productRepository, CartItemRepository $cartItemRepository)
    {
        $id = $request->get('id');
        $product = ($id) ? $productRepository->find($id): null;

        if(!$product){
            $this->addFlash('warning', 'Product not found');
            throw $this->createNotFoundException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $oldItem = $cartItemRepository->findOneBy(["user" => $currentUser, "product" => $product]);

        if(!$oldItem){
            $this->addFlash('warning', 'Item not found');
            throw $this->createNotFoundException();
        }


        if($oldItem->getQuantity() > 1)
        {
            $oldItem->setQuantity($oldItem->getQuantity() - 1);
        }
        else
        {
            $this->getDoctrine()->getManager()->remove($oldItem);
        }

        $this->getDoctrine()->getManager()->flush();
        return $this->toJsonResponse($product, $this->serializer);
    }

}