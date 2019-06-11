<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/profil")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="information_user")
     */
    public function information(Request $request)
    {
        $user = $this->getUser()->getId();
        $userInfo = $this->getDoctrine()->getRepository('App:user')->findOneBy(array('id' => $user));

        if($userInfo->getName() == null)
        {
            $userInfo->setName('Brak informacji');
            $userInfo->setZipCode('Brak informacji');
            $userInfo->setAddress('Brak informacji');
            $userInfo->setSurName('Brak informacji');
        }
        return $this->render('user/user.html.twig', array(
            'userInfo' => $userInfo,
        ));

    }

    /**
     * @Route("/edytuj", name="edit_user")
     */
    public function editUser(Request $request)
    {
        $user = $this->getUser()->getId();
        $userInfo = $this->getDoctrine()->getRepository('App:user')->findOneBy(array('id' => $user));
        $user = $userInfo;
        $editUser = $this->createForm(EditUserType::class, $user);
        $editUser->handleRequest($request);
        if ($editUser->isSubmitted() && $editUser->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Dane zostały uzupełnione');
                return $this->redirect($this->generateUrl(
                    'information_user'
                ));
        }
        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'editUser' => $editUser->createView(),

        ));
    }

    /**
     * @Route("/historia", name="user_order")
     */
    public function historyUser(Request $request)
    {

        $user = $this->getUser()->getId();
        $orderFinished = $this->getDoctrine()->getRepository('App:OrderCart')->findBy(array(
            'user' => $user));
        $history = $this->getDoctrine()->getRepository('App:HistoryOrders')->findBy(array(
            'user' => $user));

        return $this->render('user/historyUser.html.twig', array(
            'history' => $history,
            'orderFinished' => $orderFinished,
        ));

    }

    /**
     * @Route("/historia/{option}/{idOrder}", name="history")
     */
    public function history(Request $request, $option, $idOrder = null)
    {
        $order = $this->getDoctrine()->getRepository('App:HistoryOrders')->findOneBy(array('id' => $idOrder));

        if ($option == 'szczegóły') {
            $orderDetails = $this->getDoctrine()->getRepository('App:HistoryOrdersDetails')->findBy(array('numberOrder' => $order));
            return $this->render('user/historyDetails.html.twig', array(
                'orderDetails' => $orderDetails,
                'order' => $order,

            ));
        } else {

        }

    }


}