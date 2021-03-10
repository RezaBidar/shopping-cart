<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class OrderController extends BaseController
{
    /**
     * @Route("/order/submit", name="order_submit", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function submit(Request $request)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $items = $currentUser->getCartItems();
        $order = new Order();
        $order->setUser($currentUser);
        $this->getDoctrine()->getManager()->persist($order);

        foreach($items as $item)
        {
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setProduct($item->getProduct());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setPrice($item->getProduct()->getPrice());
            $this->getDoctrine()->getManager()->persist($orderItem);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->toJsonResponse($order);
    }

    /**
     * @Route("/order/{id}", name="order_details")
     * @param Order $order
     * @return Response
     */
    public function details(Order $order)
    {
        return $this->render('order.html.twig', ['order' => $order]);
    }
}