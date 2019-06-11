<?php

namespace App\Controller\menu;

use App\Entity\Categories;
use App\Entity\Subcategories;
use App\Entity\Offer;
use App\Entity\AvailabilityOffer;
use App\Entity\ShoppingCart;
use App\Entity\OfferCarModel;
use App\Form\QuantityOfferChoiceType;
use App\Form\IndividualOrderType;
use App\Form\OfferType;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/czesci")
 */
class AssortmentController extends Controller
{
    /**
     * @Route("/", name="assortment")
     */
    public function index(Request $request)
    {
        $category = $this->getDoctrine()->getRepository('App:Categories')->findAll();
        $subcategory = $this->getDoctrine()->getRepository('App:Subcategories')->findAll();

        return $this->render('menu/assortment.html.twig', array(
            'categories' => $category,
            'subcategories' => $subcategory,

        ));
    }

    /**
     * @Route("/{categoryId}", name="assortment_subcategories")
     */
    public function subcategories(Request $request, $categoryId)
    {
        $category = $this->getDoctrine()->getRepository('App:Categories')->findOneBy(array('id' => $categoryId));
        $subcategory = $this->getDoctrine()->getRepository('App:Subcategories')->findBy(array('category' => $category));
        return $this->render('assortmentPage/subcategories.html.twig', array(
            'subcategories' => $subcategory,
            'category' => $category,
        ));
    }

    /**
     * @Route("/oferta/{offerNumber}", name="search_details_assortment")
     */
    public function searchDetails(Request $request, $offerNumber)
    {
        if ($this->getUser() != null) {
            $user = $this->getUser()->getId();
            $userInfo = $this->getDoctrine()->getRepository('App:User')->findOneBy(array('id' => $user));
            $clientNumber = $userInfo->getClientNumber();
        } else {
            $clientNumber = null;
            $userInfo = null;
        }
        $offer = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $offerNumber));
        $car = $this->getDoctrine()->getRepository('App:OfferCarModel')->findBy(array('offer' => $offer));
        $photo = $this->getDoctrine()->getRepository('App:OfferPhotos')->findBy(array('offer' => $offer));
        if ($clientNumber != null) {

            $discountCard = $this->getDoctrine()->getRepository('App:DiscountCard')->findOneBy(array(
                'clientNumber' => $clientNumber));
            if ($discountCard != null) {
                $discount = $discountCard->getDiscount();
                $priceFinished = $offer->getPrice() - ($discount / 100 * $offer->getPrice());
                $priceFinished = round($priceFinished, 2);
            } else {
                $priceFinished = $offer->getPrice();
            }
        } else {
            $priceFinished = $offer->getPrice();
        }
        $QuantityOfferChoice = new Offer();

        $quantity = $offer->getQuantity();
        $form = $this->createForm(QuantityOfferChoiceType::class, $QuantityOfferChoice, array('quantity' => $quantity));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $addOffer = new ShoppingCart();
            $addOffer->setOffer($offer);
            $addOffer->setUser($userInfo);
            $addOffer->setQuantity($QuantityOfferChoice->getQuantity());
            $addOffer->setPrice($priceFinished * $QuantityOfferChoice->getQuantity());
            $addOffer->setIndividualOrder(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($addOffer);
            $em->flush();
            $this->addFlash('success', 'Dodano oferte do koszyka');
            return $this->redirectToRoute('search_details_assortment', array('offerNumber' => $offer->getId()));
        }

        $individualOrder = new Offer();
        $individualOrderForm = $this->createForm(IndividualOrderType::class, $individualOrder);
        $individualOrderForm->handleRequest($request);
        if ($individualOrderForm->isSubmitted()) {
            $addOffer = new ShoppingCart();
            $addOffer->setOffer($offer);
            $addOffer->setUser($userInfo);
            $addOffer->setQuantity($individualOrder->getQuantity());
            $addOffer->setPrice($priceFinished * $individualOrder->getQuantity());
            $availabilityOffer = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $offer->getId()));
            if ($availabilityOffer != null) {
                if ($availabilityOffer->getQuantity() >= $addOffer->getQuantity()) {
                    $addOffer->setIndividualOrder(false);
                } else {
                    $addOffer->setIndividualOrder(true);
                }
            } else {
                $addOffer->setIndividualOrder(true);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($addOffer);
            $em->flush();
            $this->addFlash('success', 'Dodano oferte do koszyka');
            return $this->redirectToRoute('search_details_assortment', array('offerNumber' => $offer->getId()));
        }
        return $this->render('assortmentPage/details_assortment.html.twig', array(
            'offer' => $offer,
            'price' => $priceFinished,
            'car' => $car,
            'form' => $form->createView(),
            'individualOrderForm' => $individualOrderForm->createView(),
            'photos' => $photo,
            'userInfo' => $userInfo,
        ));

    }

    /**
     * @Route("/zamow/{offerId}", name="order")
     */
    public function order(Request $request, $offerId)
    {
        $offer = $this->getDoctrine()->getRepository('App:Offer')->find($offerId);
        dump($offer);
        die();

        return $this->render('assortmentPage/details_assortment.html.twig', array(
            'offer' => $offer,
            'availability' => $availability,
        ));

    }


}