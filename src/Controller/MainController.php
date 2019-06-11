<?php
namespace App\Controller;

use App\Entity\Institution;
use App\Entity\SearchOffer;
use App\Form\ContactType;
use App\Form\SearchOfferType;
use App\Entity\Offer;
use App\Form\OfferType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\AcceptHeader;

class MainController extends Controller{
    /**
     * @Route("/", name="mainPage")
     */
    public function index(){
        $photos = $this->getDoctrine()->getRepository('App:MainPagePhoto')->findAll();
        $text = $this->getDoctrine()->getRepository('App:MainPage')->findAll();

        return $this->render('mainPage/mainPage.html.twig', array(
            'photos' => $photos,
            'text' => $text,
        ));
    }
    /**
     * @Route("/kontakt/", name="contact")
     */
    public function contact(Request $request)
    {

            $contact = $this->getDoctrine()->getRepository('App:Institution')->findAll();
            $phone = $this->getDoctrine()->getRepository('App:InstitutionPhone')->findAll();
        return $this->render('contact.html.twig', array(
            'contact' => $contact,
            'phone' => $phone,
        ));

    }
    /**
     * @Route("/punkty-sprzedazy/{city}", name="points_of_sale")
     */
    public function institution(Request $request, $city =null)
    {
        if($city == null)
        {
            $institution = $this->getDoctrine()->getRepository('App:Institution')->findAll();
        }
        else
        {
            $institution = $this->getDoctrine()->getRepository('App:Institution')->findBy(array('city' => $city));
        }
        $findCity = $this->getDoctrine()->getRepository('App:Institution')->findAll();
        foreach ($findCity as $item) {
            $allCity[] = $item->getCity();
        }
        $arrayCity = array_unique($allCity);
        $shop = new Institution();
        $findShops = $this->createForm(ContactType::class, $shop,array('city' => $arrayCity));
        $findShops->handleRequest($request);
        if ($findShops->isSubmitted() && $findShops->isValid()) {
            $city=$shop->getCity();
            return $this->redirect($this->generateUrl(
                'points_of_sale', array('city' => $city)
            ));
        }
        return $this->render('institution.html.twig', array(
            'institution' => $institution,
            'findShops' => $findShops->createView(),
        ));
    }

}