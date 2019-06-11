<?php

namespace App\Controller\menu;


use App\Entity\Order;
use App\Entity\OrderCart;
use App\Entity\OrderDetails;
use App\Entity\ShoppingCart;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/koszyk")
 */
class ShoppingCartController extends Controller
{
    /**
     * @Route("/", name="shopping_cart")
     */
    public function shoppingCart(Request $request)
    {

        $user = $this->getUser();
        if($user != null)
        {
            if ($user->getRodo() == true) {
                $choice = [OrderCart::receipt, OrderCart::invoice];
            } else {
                $choice = [OrderCart::receipt];
            }
        }

        $orderChoice = [OrderCart::all, OrderCart::individual];
        if ($user != null) {
            $user = $this->getUser()->getId();
            $userInfo = $this->getDoctrine()->getRepository('App:user')->findOneBy(array('id' => $user));
            $shoppingCart = $this->getDoctrine()->getRepository('App:ShoppingCart')->findBy(array('user' => $userInfo));

            return $this->render('shoppingCart/shoppingCartUserOnline.html.twig', array(
                'shoppingCart' => $shoppingCart,
                'choice' => $choice,
                'orderChoice' => $orderChoice,
            ));
        } else {

            return $this->render('shoppingCart/shoppingCartUserOffline.html.twig', array(
            ));
        }

    }

    /**
     * @Route("/blad", name="shopping_cart_error")
     */
    public function shoppingCartError(Request $request, $badQuantity, $availableOffer)
    {
        return $this->render('shoppingCart/error.html.twig', array(
            'shoppingCart' => $badQuantity,
            'availableOffer' => $availableOffer,
        ));
    }

    /**
     * @Route("/{option}/{offerId}/{shoppingCartId}", name="add_shopping_cart")
     */
    public function addOfferInShoppingCart(Request $request, $option, $offerId, $quantity = null, $institution = null, $shoppingCartId = null, $individual = null)
    {
        $user = $this->getUser();
        if ($option == ShoppingCart::delete) {
            $shoppingCart = $this->getDoctrine()->getRepository('App:ShoppingCart')->findOneBy(array('id' => $shoppingCartId));
            $em = $this->getDoctrine()->getManager();
            $em->remove($shoppingCart);
            $em->flush();
            return $this->redirectToRoute('shopping_cart');
        }
    }

    /**
     * @Route("/podsumowanie", name="summary")
     */
    public function summary(Request $request)
    {
        if ($request->query->get('orderSeparately') == OrderCart::all) {
            $orderSeparately = false;
        } else {
            $orderSeparately = true;
        }

        $user = $this->getUser()->getId();
        $dataTime = (new \DateTime());
        $userInfo = $this->getDoctrine()->getRepository('App:User')->findOneBy(array('id' => $user));
        $orderStatus = $this->getDoctrine()->getRepository('App:OrderStatus')->findOneBy(array('numberStatus' => OrderCart::acceptedForImplementation));
        $clientNumber = $userInfo->getClientNumber();
        if ($orderSeparately == true) {
            $orderArray = array('orderNormal', 'orderSeparately');
        } else {
            $orderArray = array('orderNormal');
        }
        foreach ($orderArray as $item) {
            $order = new OrderCart();
            $order->setUser($userInfo);
            $order->setDateOrder($dataTime);
            $order->setStatus($orderStatus);
            $order->setProofOfPurchase($request->query->get('proofOfPurchase'));

            if ($orderSeparately == false) {
                $offer = $this->getDoctrine()->getRepository('App:ShoppingCart')->findBy(array('user' => $userInfo));
            } else {
                if ($item == 'orderNormal') {
                    $offer = $this->getDoctrine()->getRepository('App:ShoppingCart')->findBy(array('user' => $userInfo, 'individualOrder' => 0));
                }
            }
            if ($item == 'orderSeparately') {
                $offer = $this->getDoctrine()->getRepository('App:ShoppingCart')->findBy(array('user' => $userInfo, 'individualOrder' => 1));
            }
            $checkOffer = $this->getDoctrine()->getRepository('App:ShoppingCart')->findBy(array('user' => $userInfo, 'individualOrder' => false));
            $priceFinished = 0;
            $badQuantity = [];
            $availableOffer = [];
            foreach ($checkOffer as $item) {
                $availableQuantity = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $item->getOffer()->getId()));
                if ($availableQuantity->getQuantity() < $item->getQuantity()) {
                    $badQuantity[] = $item;
                    $availableOffer[] = $availableQuantity;
                }
            }
            if ($badQuantity != null) {
                $response = $this->forward('App\Controller\menu\ShoppingCartController::shoppingCartError', [
                    'badQuantity' => $badQuantity,
                    'availableOffer' => $availableOffer,
                ]);
                return $response;
            }

            foreach ($offer as $item) {
                if ($item->getIndividualOrder() == false) {
                    $quantity = $item->getQuantity();
                    $availableQuantity = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $item->getOffer()->getId()));
                    $newQuantity = $availableQuantity->getQuantity() - $quantity;
                    $availableQuantity->setQuantity($newQuantity);
                }
                $priceFinished = $priceFinished + ($item->getPrice());
            }
            $order->setPrice($priceFinished);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            $orderCart = $this->getDoctrine()->getRepository('App:OrderCart')->findOneBy(array('user' => $user, 'id' => $order->getId()));
            $orderCartArray[] = $orderCart;
            foreach ($offer as $item) {

                $quantity = $item->getQuantity();
                $totalPrice = $item->getPrice();
                $price = $totalPrice / $quantity;
                $orderDetails = new OrderDetails();
                $orderDetails->setNumber($orderCart);
                $orderDetails->setQuantity($quantity);
                $orderDetails->setName($item->getOffer()->getName());
                $orderDetails->setPrice($price);
                $orderDetails->setTotalPrice($totalPrice);
                $orderDetails->setUser($userInfo);
                $orderDetails->setOffer($item->getOffer());
                if ($item->getIndividualOrder() == false) {
                    $orderDetails->setAvailable(1);
                } else {
                    $orderDetails->setAvailable(0);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($orderDetails);
                $em->remove($item);
                $em->flush();
            }
        }

        $details = $this->getDoctrine()->getRepository('App:OrderDetails')->findBy(array('number' => $orderCartArray));

        return $this->render('shoppingCart/summary.html.twig', array(
            'orderCart' => $orderCartArray,
            'details' => $details,
        ));
    }
}