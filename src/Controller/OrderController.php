<?php

namespace App\Controller;


use App\Entity\HistoryOrders;
use App\Entity\HistoryOrdersDetails;
use App\Entity\Order;
use App\Entity\OrderCart;
use App\Entity\OrderDetails;
use App\Entity\ShoppingCart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/zamowienia")
 */
class OrderController extends Controller
{
    /**
     * @Route("/", name="order_cart")
     */
    public function shoppingCart(Request $request)
    {

        $user = $this->getUser();

        if ($user != null) {
            $user = $this->getUser()->getId();
            $userInfo = $this->getDoctrine()->getRepository('App:user')->findOneBy(array('id' => $user));
            $shoppingCart = $this->getDoctrine()->getRepository('App:ShoppingCart')->findBy(array('user' => $userInfo));

            return $this->render('shoppingCart/shoppingCartUserOnline.html.twig', array(
                'shoppingCart' => $shoppingCart,
            ));
        } else {

            return $this->render('shoppingCart/shoppingCartUserOffline.html.twig', array(
//            'categories' => $categories,
//            'subCategories' => $subCategories,

            ));
        }

    }

    /**
     * @Route("/sklepy", name="order_shop")
     */
    public function shop(Request $request)
    {
        $institution = $this->getDoctrine()->getRepository('App:Institution')->findAll();

        return $this->render('order/shop.html.twig', array(
            'institution' => $institution,
        ));
    }

    /**
     * @Route("/realizacja", name="order_implementation")
     */
    public function selectShop(Request $request)
    {
        $acceptedForImplementation = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array('numberStatus' => OrderCart::acceptedForImplementation));
        $inImplementation = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array('numberStatus' => OrderCart::inImplementation));
        $finished = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array('numberStatus' => OrderCart::finished));
        $statusOrdered = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array('numberStatus' => OrderCart::ordered));
        $orderAcceptedForImplementation = $this->getDoctrine()->getRepository('App:OrderCart')->findBy(array('status' => $acceptedForImplementation));
        $orderInImplementation = $this->getDoctrine()->getRepository('App:OrderCart')->findBy(array('status' => $inImplementation));
        $orderFinished = $this->getDoctrine()->getRepository('App:OrderCart')->findBy(array('status' => $finished));
        $ordered = $this->getDoctrine()->getRepository('App:OrderCart')->findBy(array('status' => $statusOrdered));
        return $this->render('order/orderImplementation.html.twig', array(
            'acceptedForImplementation' => $orderAcceptedForImplementation,
            'inImplementation' => $orderInImplementation,
            'finished' => $orderFinished,
            'ordered' => $ordered,
        ));
    }

    /**
     * @Route("/szczegoly/{option}/{idOrder}", name="order_details")
     */
    public function orderDetails(Request $request, $option, $idOrder)
    {
        $order = $this->getDoctrine()->getRepository('App:OrderCart')->findOneBy(array('id' => $idOrder));
        $orderDetails = $this->getDoctrine()->getRepository('App:OrderDetails')->findBy(array('number' => $order));
        if ($option == OrderCart::acceptedForImplementation) {
            $status = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array('numberStatus' => OrderCart::inImplementation));
            $order->setStatus($status);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            return $this->render('order/order.html.twig', array(
                'order' => $order,
                'orderDetails' => $orderDetails,
            ));
        } else {
            if ($option == OrderCart::finished) {
                return $this->render('order/orderFinished.html.twig', array(
                    'order' => $order,
                    'orderDetails' => $orderDetails,
                ));
            } else {
                return $this->render('order/waitingForParts.html.twig', array(
                    'order' => $order,
                    'orderDetails' => $orderDetails,
                ));
            }
        }
    }
    /**
     * @Route("/{option}/{idOrder}", name="order_status")
     */
    public function orderStatus(Request $request, $option = null, $idOrder)
    {
        $order = $this->getDoctrine()->getRepository('App:OrderCart')->findOneBy(array('id' => $idOrder));
        if ($option == OrderCart::inImplementation) {
            $status = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array(
                'numberStatus' => OrderCart::finished));
            $order->setStatus($status);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            $this->addFlash('success-finished','Status ofetry zmieniony na gotowe do obioru');
            return $this->redirectToRoute('order_implementation');
        } else {
            if ($option == OrderCart::finished) {
                $orderDetails = $this->getDoctrine()->getRepository('App:OrderDetails')->findBy(array('number' => $order));
                $historyOrders = new HistoryOrders();
                $historyOrders->setUser($order->getUser());
                $historyOrders->setDateOrder(new \DateTime());
                $historyOrders->setPrice($order->getPrice());
                $historyOrders->setInstitution($order->getInstitution());
                $em = $this->getDoctrine()->getManager();
                $em->persist($historyOrders);
                $em->flush();
                foreach ($orderDetails as $item)
                {
                    dump($item->getNumber());
                    $historyOrdersDetails = new HistoryOrdersDetails();
                    $historyOrdersDetails->setNumberOrder($historyOrders);
                    $historyOrdersDetails->setOffer($item->getOffer());
                    $historyOrdersDetails->setQuantity($item->getQuantity());
                    $historyOrdersDetails->setPrice($item->getPrice());
                    $historyOrdersDetails->setTotalPrice($item->getTotalPrice());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($historyOrdersDetails);
                    $em->flush();
                }

                $em = $this->getDoctrine()->getManager();
                $em->remove($order);
                $em->flush();
                $this->addFlash('success-received','Zamówienie zostało odebrane');
                return $this->redirectToRoute('select_shop', array('shop' => $order->getInstitution()->getId()));
            } else {
                $status = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array('numberStatus' => OrderCart::ordered));
                $order->setStatus($status);
                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();
                $this->addFlash('success-ordered','Status ofetry zmieniony na zamówione');
                return $this->redirectToRoute('order_implementation');
            }
        }

    }
}