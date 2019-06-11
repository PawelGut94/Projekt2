<?php

namespace App\Controller;

use App\Entity\AvailabilityOffer;
use App\Entity\CarMark;
use App\Entity\CarModel;
use App\Entity\Institution;
use App\Entity\InstitutionPhone;
use App\Entity\MainPage;
use App\Entity\Offer;
use App\Entity\OfferCarMark;
use App\Entity\Categories;
use App\Entity\SearchOffer;
use App\Entity\User;
use App\Entity\OfferCarModel;
use App\Entity\OfferPhotos;
use App\Entity\MainPagePhoto;
use App\Entity\Subcategories;
use App\Form\AvailabilityOfferType;
use App\Form\CarMarkType;
use App\Form\CarModelType;
use App\Form\CategoriesType;
use App\Form\ChangePasswordType;
use App\Form\MainPagePhotoType;
use App\Form\MainPageTextType;
use App\Form\CreateUserType;
use App\Form\InstitutionType;
use App\Form\MainPageType;
use App\Form\OfferAddAvailabilityType;
use App\Form\OfferAddCarType;
use App\Form\OfferDeleteSelectedCarType;
use App\Form\OfferEditType;
use App\Form\OfferType;
use App\Form\CreateAdminType;
use App\Form\OfferAddPhotoType;
use App\Form\InstitutionEditType;
use App\Form\OfferPhotoType;
use App\Form\InstitutionPhoneType;
use App\Form\SubcategoriesType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/administracja")
 */
class AdministrationController extends Controller
{
    /**
     * @Route("/uzytkownicy", name="administration_user")
     */
    public function user(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findAll();
        $createUser = new User();
        $formUser = $this->createForm(CreateUserType::class, $createUser);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $createUser->setEnabled(1);
            $email = $this->getDoctrine()->getRepository('App:User')->findBy(array('email' => $createUser->getEmail()));
            $login = $this->getDoctrine()->getRepository('App:User')->findBy(array('username' => $createUser->getUsername()));
            if ($email != null or $login != null) {
                if ($login != null) {
                    $this->addFlash('error-login', 'Podaany login jest już zajęty');
                }
                if ($email != null) {
                    $this->addFlash('error-email', 'Podany email jest już zajęty');
                }
                return $this->render('administration/user.html.twig', array(
                    'user' => $user,
                    'formUser' => $formUser->createView(),
                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($createUser);
                $em->flush();
                $this->addFlash('success', 'Dodano nowego użytkownika');
                return $this->redirect($this->generateUrl(
                    'administration_user'
                ));
            }
        }
        return $this->render('administration/user.html.twig', array(
            'user' => $user,
            'formUser' => $formUser->createView(),
        ));
    }

    /**
     * @Route("/administratorzy", name="administration_admin")
     */
    public function admin(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findAll();
        $createAdmin = new User();
        $formAdmin = $this->createForm(CreateUserType::class, $createAdmin);
        $formAdmin->handleRequest($request);
        if ($formAdmin->isSubmitted() && $formAdmin->isValid()) {
            $createAdmin->setRoles(array("ROLE_ADMIN"));
            $createAdmin->setEnabled(1);
            $email = $this->getDoctrine()->getRepository('App:User')->findBy(array('email' => $createAdmin->getEmail()));
            $login = $this->getDoctrine()->getRepository('App:User')->findBy(array('username' => $createAdmin->getUsername()));
            if ($email != null or $login != null) {
                if ($login != null) {
                    $this->addFlash('error-login', 'Podaany login jest już zajęty');
                }
                if ($email != null) {
                    $this->addFlash('error-email', 'Podany email jest już zajęty');
                }
                return $this->render('administration/admin.html.twig', array(
                    'user' => $user,
                    'formAdmin' => $formAdmin->createView(),
                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($createAdmin);
                $em->flush();
                $this->addFlash('success', 'Dodano nowego administratora');
                return $this->redirect($this->generateUrl(
                    'administration_user'
                ));
            }
        }
        return $this->render('administration/admin.html.twig', array(
            'user' => $user,
            'formAdmin' => $formAdmin->createView(),


        ));
    }

    /**
     * @Route("/uzytkownicy/{option}/{idUser}", name="administration_user_option")
     */
    public function userOption(UserPasswordEncoderInterface $encoder, Request $request, $option, $idUser)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findOneBy(array('id' => $idUser));
        if ($option == 'szczegóły') {
            if ($user->getName() == null) {
                $user->setName('Brak informacji');
                $user->setZipCode('Brak informacji');
                $user->setAddress('Brak informacji');
                $user->setSurName('Brak informacji');
            }
            return $this->render('administration/userDetails.html.twig', array(
                'user' => $user,
            ));
        } else {
            if ($option == 'zmień-hasło') {
                $changePassword = $user;
                $form = $this->createForm(ChangePasswordType::class, $changePassword);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $encoded = $encoder->encodePassword($changePassword, $changePassword->getPlainPassword());
                    $changePassword->setPassword($encoded);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($changePassword);
                    $em->flush();
                    $this->addFlash('success', 'Hasło zostało zmienione');
                    return $this->redirect($this->generateUrl(
                        'administration_user'
                    ));
                }
                return $this->render('administration/userChangePassword.html.twig', array(
                    'form' => $form->createView(),
                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
                return $this->redirectToRoute('administration_user');
            }
        }
    }

    /**
     * @Route("/administratorzy/{option}/{idUser}", name="administration_admin_option")
     */
    public function adminOption(UserPasswordEncoderInterface $encoder, Request $request, $option, $idUser)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findOneBy(array('id' => $idUser));
        if ($option == 'szczegóły') {
            if ($user->getName() == null) {
                $user->setName('Brak informacji');
                $user->setZipCode('Brak informacji');
                $user->setAddress('Brak informacji');
                $user->setSurName('Brak informacji');
            }
            return $this->render('administration/adminDetails.html.twig', array(
                'user' => $user,
            ));
        } else {
            if ($option == 'zmień-hasło') {
                $changePassword = $user;
                $form = $this->createForm(ChangePasswordType::class, $changePassword);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $encoded = $encoder->encodePassword($changePassword, $changePassword->getPlainPassword());
                    $changePassword->setPassword($encoded);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($changePassword);
                    $em->flush();
                    $this->addFlash('success', 'Hasło zostało zmienione');
                    return $this->redirect($this->generateUrl(
                        'administration_admin'
                    ));
                }
                return $this->render('administration/adminChangePassword.html.twig', array(
                    'form' => $form->createView(),
                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
                return $this->redirectToRoute('administration_admin');
            }
        }
    }

    /**
     * @Route("/asortyment", name="administration_assortment")
     */
    public function assortment(Request $request)
    {
        $assortment = $this->getDoctrine()->getRepository('App:Offer')->findAll();
        $categories = $this->getDoctrine()->getRepository('App:Categories')->findAll();

        $offer = new Offer();
        $carMark = new OfferCarMark();
        $offerPhoto = new OfferPhotos();
        $offer->addOfferCarMark($carMark);
        $offer->addOfferPhoto($offerPhoto);
        $createOffer = $this->createForm(OfferType::class, $offer);
        $createOffer->handleRequest($request);

        if ($createOffer->isSubmitted() && $createOffer->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $offerCarsMark = $offer->getOfferCarMark();
            foreach ($offerCarsMark as $offerCar) {
                $offerCar->setOffer($offer);
            }
            $photo = $offer->getOfferPhotos();
            foreach ($photo as $addPhoto) {
                $addPhoto->setOffer($offer);
                $photoName = $addPhoto->getPhoto()->getClientOriginalName();
                $addPhoto->setPhoto($photoName);
            }
            $uploads_directory = $this->getParameter('uploads_directory');
            $file = $request->files->get('app_offer')['offerPhotos'];
            foreach ($file as $item) {
                foreach ($item as $photo) {
                    $name = $photo->getClientOriginalName();
                    $fileName = $name;
                    $photo->move(
                        $uploads_directory,
                        $fileName
                    );

                }
            }
            $response = $this->forward('App\Controller\AdministrationController::assortment2', [
                'offer' => $offer,
            ]);
            return $response;
        }

        return $this->render('administration/assortment.html.twig', array(
            'assortment' => $assortment,
            'createOffer' => $createOffer->createView(),
            'categories' => $categories,

        ));
    }

    /**
     * @Route("/asortyment/2", name="administration_assortment2")
     */
    public function assortment2(Request $request, $offer)
    {
        $mark = $offer->getOfferCarMark();
        $tabMark = [];
        foreach ($mark as $item) {
            $tabMark[] = $item->getCarMark()->getName();;
        }
        $car = $this->getDoctrine()->getRepository('App:CarMark')->findBy(array('name' => $tabMark));
        $model = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('mark' => $car));
        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();

        $offerId = $offer->getId();

        return $this->render('administration/assortment2.html.twig', array(
            'mark' => $tabMark,
            'model' => $model,
            'offer' => $offerId,

        ));
    }

    /**
     * @Route("/asortyment/{offer}", name="administration_assortment3")
     */
    public function assortment3(Request $request, $offer)
    {
        $arrayModel = $request->query;
        $model = [];
        foreach ($arrayModel as $item) {
            $model[] = $item;
        }
        $findOffer = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $offer));
        $car = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('name' => $model));
        foreach ($car as $item) {
            $offerCarModel = new OfferCarModel();
            $offerCarModel->setOffer($findOffer);
            $offerCarModel->setCarModel($item);
            $em = $this->getDoctrine()->getManager();
            $em->persist($offerCarModel);
            $em->flush();
        }
        $this->addFlash('success', 'Oferta została utworzona');
        return $this->redirect($this->generateUrl(
            'administration_assortment'
        ));
    }

    /**
     * @Route("/asortyment/{option}/{offer}", name="administration_assortment_option")
     */
    public function assortmentOption(Request $request, $option, $offer)
    {
        $assortment = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $offer));
        $mark = $this->getDoctrine()->getRepository('App:offerCarMark')->findBy(array('offer' => $assortment));
        $model = $this->getDoctrine()->getRepository('App:offerCarModel')->findBy(array('offer' => $assortment));
        $institution = $this->getDoctrine()->getRepository('App:AvailabilityOffer')->findBy(array('offer' => $offer));
        $photos = $this->getDoctrine()->getRepository('App:OfferPhotos')->findBy(array('offer' => $offer));
        if ($option == 'szczegóły') {
            return $this->render('administration/assortmentDetails.html.twig', array(
                'assortment' => $assortment,
                'mark' => $mark,
                'model' => $model,
                'institution' => $institution,
                'photos' => $photos,
            ));
        } else {
            if ($option == 'edytuj') {
                $offerEdit = $assortment;
                $formOffer = $this->createForm(OfferEditType::class, $offerEdit);
                $formOffer->handleRequest($request);
                if ($formOffer->isSubmitted() && $formOffer->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($offerEdit);
                    $em->flush();
                    $this->addFlash('success', 'Zaktualizowano oferte');
                    return $this->redirect($this->generateUrl(
                        'administration_assortment_option', array('option' => 'szczegóły', 'offer' => $offer)
                    ));
                }
                return $this->render('administration/OfferEditMainInformation.html.twig', array(
                    'formOffer' => $formOffer->createView(),
                    'offer' => $offer,
                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($assortment);
                $em->flush();
                return $this->redirectToRoute('administration_assortment');
            }
        }
    }

    /**
     * @Route("/asortyment/zdjecia/{option}/{offer}", name="administration_assortment_photo_option")
     */
    public function assortmentPhoto(Request $request, $option, $offer)
    {
        if ($option == 'dodaj') {
            $assortment = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $offer));
            $offerPhotos = new Offer();
            $photo = new OfferPhotos();
            $offerPhotos->addOfferPhoto($photo);
            $photo = $this->createForm(OfferAddPhotoType::class, $offerPhotos);
            $photo->handleRequest($request);
            if ($photo->isSubmitted()) {

                $photos = $offerPhotos->getOfferPhotos();
                foreach ($photos as $addPhoto) {
                    $addPhoto->setOffer($offerPhotos);
                    $photoName = $addPhoto->getPhoto()->getClientOriginalName();
                    $addPhoto->setPhoto($photoName);
                }
                $uploads_directory = $this->getParameter('uploads_directory');
                $file = $request->files->get('app_offerPhotos')['offerPhotos'];
                foreach ($file as $item) {
                    foreach ($item as $photo) {
                        $name = $photo->getClientOriginalName();
                        $fileName = $name;
                        $photo->move(
                            $uploads_directory,
                            $fileName
                        );
                    }
                }
                foreach ($offerPhotos->getOfferPhotos() as $item) {
                    $namePhoto[] = $item->getPhoto();
                }
                foreach ($namePhoto as $item) {
                    $addPhotos = new OfferPhotos();
                    $addPhotos->setPhoto($item);
                    $addPhotos->setOffer($assortment);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($addPhotos);
                    $em->flush();
                }
                $this->addFlash('success', 'Dodano nowe zdjęcia');
                return $this->redirect($this->generateUrl(
                    'administration_assortment_option', array('option' => 'szczegóły', 'offer' => $assortment->getId())
                ));
            }
            return $this->render('administration/OfferAddPhoto.html.twig', array(
                'photo' => $photo->createView(),
            ));
        } else {
            $photo = $this->getDoctrine()->getRepository('App:OfferPhotos')->findOneBy(array('id' => $offer));
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
            return $this->redirectToRoute('administration_assortment_option', array('option' => 'szczegóły', 'offer' => $photo->getOffer()->getId()));
        }
    }

    /**
     * @Route("/asortyment/samochody/{option}/{offer}/{mark}", name="administration_assortment_car_option")
     */
    public function assortmentCar(Request $request, $option, $offer, $mark = null)
    {
        $assortment = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $offer));
        $findMark = $this->getDoctrine()->getRepository('App:CarMark')->findOneBy(array('id' => $mark));
        $model = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('mark' => $findMark));
        $offerMark = $this->getDoctrine()->getRepository('App:OfferCarMark')->findOneBy(array('offer' => $assortment, 'carMark' => $findMark));
        $offerModel = $this->getDoctrine()->getRepository('App:OfferCarModel')->findBy(array('offer' => $assortment, 'carModel' => $model));
        if ($option == 'dodaj') {
            $car = new SearchOffer();
            $form = $this->createForm(OfferAddCarType::class, $car);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                }
                if ($form->get('save')->isClicked()) {
                    $markChceck = $this->getDoctrine()->getRepository('App:OfferCarMark')->findOneBy(array('offer' => $assortment, 'carMark' => $car->getMark()));
                    if ($markChceck == null) {
                        $addMark = new OfferCarMark();
                        $addMark->setOffer($assortment);
                        $addMark->setCarMark($car->getMark());
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($addMark);
                        $em->flush();
                    }
                    $value = $request->request->get('app_offer2');
                    $check = false;
                    if (array_key_exists('model', $value)) {
                        $check = true;
                    }
                    if ($check == true) {
                        $models = $request->request->get('app_offer2')['model'];
                        foreach ($models as $item) {
                            $model = $this->getDoctrine()->getRepository('App:CarModel')->findOneBy(array('id' => $item));
                            $modelCheck = $this->getDoctrine()->getRepository('App:OfferCarModel')->findOneBy(array('offer' => $assortment, 'carModel' => $model));
                            if ($modelCheck == null) {
                                $addModel = new OfferCarModel();
                                $addModel->setOffer($assortment);
                                $addModel->setCarModel($model);
                                $em = $this->getDoctrine()->getManager();
                                $em->persist($addModel);
                                $em->flush();
                            }
                        }

                        $this->addFlash('success', 'Dodano samochody do oferty');
                        return $this->redirect($this->generateUrl(
                            'administration_assortment_option', array('option' => 'szczegóły', 'offer' => $offer)
                        ));
                    } else {
                        $this->addFlash('error', 'Te pole nie może być puste');
                        return $this->render('administration/OfferAddCar.html.twig', array(
                            'form' => $form->createView(),
                            'offer' => $offer,
                        ));
                    }
                }

            }
            return $this->render('administration/OfferAddCar.html.twig', array(
                'form' => $form->createView(),
                'offer' => $offer,
            ));
        } else {
            if ($option == 'usun-wybrane') {
                $quantityModelChoices = 0;
                foreach ($offerModel as $item) {
                    $modelChoices[] = $item->getCarModel();
                    $quantityModelChoices = $quantityModelChoices + 1;
                }
                $car = new CarModel();
                $car->setMark($findMark);
                $form = $this->createForm(OfferDeleteSelectedCarType::class, $car, array('model' => $modelChoices));
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $value = $request->request->get('offer_delete_selected_car');
                    $check = false;
                    if (array_key_exists('name', $value)) {
                        $check = true;
                    }
                    if ($check == true) {
                        $quantityModelDelete = 0;
                        $request->request->get('offer_delete_selected_car');
                        $choices = $request->request->get('offer_delete_selected_car')['name'];
                        foreach ($choices as $item) {
                            $quantityModelDelete = $quantityModelDelete + 1;
                            $search = $modelChoices[$item];
                            $offerModel = $this->getDoctrine()->getRepository('App:OfferCarModel')->findOneBy(array('offer' => $assortment, 'carModel' => $search));
                            $em = $this->getDoctrine()->getManager();
                            $em->remove($offerModel);
                            $em->flush();
                        }
                        if ($quantityModelChoices == $quantityModelDelete) {
                            $em = $this->getDoctrine()->getManager();
                            $em->remove($offerMark);
                            $em->flush();
                        }
                        $this->addFlash('success', 'Samochód został usunięty');
                        return $this->redirectToRoute('administration_assortment_option', array('option' => 'szczegóły', 'offer' => $assortment->getId()));
                    } else {
                        $this->addFlash('error', 'Te pole nie może być puste');
                        return $this->render('administration/OfferSelectedDeleteCar.html.twig', array(
                            'form' => $form->createView(),
                            'offer' => $offer,
                        ));
                    }
                }
                return $this->render('administration/OfferSelectedDeleteCar.html.twig', array(
                    'form' => $form->createView(),
                    'offer' => $offer,
                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($offerMark);
                $em->flush();
                foreach ($offerModel as $item) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($item);
                    $em->flush();
                }
                $this->addFlash('success', 'Samochód został usunięty');
                return $this->redirectToRoute('administration_assortment_option', array('option' => 'szczegóły', 'offer' => $assortment->getId()));
            }
        }
    }

    /**
     * @Route("/sklepy", name="administration_shop")
     */
    public function shop(Request $request)
    {
        $shop = $this->getDoctrine()->getRepository('App:Institution')->findAll();
        $institution = new Institution();
        $institutionPhone = new InstitutionPhone();
        $institution->addInstitutionPhone($institutionPhone);
        $createShop = $this->createForm(InstitutionType::class, $institution);
        $createShop->handleRequest($request);
        if ($createShop->isSubmitted() && $createShop->isValid()) {

            $name = $institution->getCity() . ' ' . $institution->getAddress();
            $institution->setName($name);
            $addPhone = $institution->getInstitutionPhones();
            foreach ($addPhone as $item) {
                $item->setInstitution($institution);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($institution);
            $em->flush();
            $this->addFlash('success', 'Dodano nowy sklep');

            return $this->redirect($this->generateUrl(
                'administration_shop'
            ));
        }
        return $this->render('administration/shop.html.twig', array(
            'shop' => $shop,
            'createShop' => $createShop->createView(),

        ));
    }

    /**
     * @Route("/sklepy/{option}/{idShop}", name="administration_shop_option")
     */
    public function shopOption(Request $request, $option, $idShop)
    {
        $shop = $this->getDoctrine()->getRepository('App:Institution')->findOneBy(array('id' => $idShop));
        if ($option == 'szczegóły') {
            $phone = $this->getDoctrine()->getRepository('App:InstitutionPhone')->findBy(array('institution' => $shop));
            return $this->render('administration/shopDetails.html.twig', array(
                'shop' => $shop,
                'phone' => $phone,
            ));
        } else {
            if ($option == 'edytuj') {
                $phone = $this->getDoctrine()->getRepository('App:InstitutionPhone')->findBy(array('institution' => $shop));
                $shop->getInstitutionPhones($phone);
                $editShop = $this->createForm(InstitutionEditType::class, $shop);
                $editShop->handleRequest($request);
                if ($editShop->isSubmitted() && $editShop->isValid()) {
                    $name = $shop->getCity() . ' ' . $shop->getAddress();
                    $shop->setName($name);
                    $addPhone = $shop->getInstitutionPhones();
                    foreach ($addPhone as $item) {
                        $item->setInstitution($shop);
                    }

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($shop);
                    $em->flush();

                    return $this->redirect($this->generateUrl(
                        'administration_shop'
                    ));

                }
                return $this->render('administration/shopEdit.html.twig', array(
                    'shop' => $shop,
                    'editShop' => $editShop->createView(),

                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($shop);
                $em->flush();
                return $this->redirectToRoute('administration_shop');
            }
        }
    }

    /**
     * @Route("/kategorie", name="administration_categories")
     */
    public function categories(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('App:Categories')->findAll();
        $subcategories = $this->getDoctrine()->getRepository('App:Subcategories')->findAll();
        $newCategory = new Categories();
        $createCategory = $this->createForm(CategoriesType::class, $newCategory);
        $createCategory->handleRequest($request);
        if ($createCategory->isSubmitted() && $createCategory->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newCategory);
            $em->flush();
            $this->addFlash('success-category', 'Dodano nową kategorie');

            return $this->redirect($this->generateUrl(
                'administration_categories'
            ));
        }
        $newSubcategories = new Subcategories();
        $createSubcategories = $this->createForm(SubcategoriesType::class, $newSubcategories);
        $createSubcategories->handleRequest($request);
        if ($createSubcategories->isSubmitted() && $createSubcategories->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newSubcategories);
            $em->flush();
            $this->addFlash('success-subcategory', 'Dodano nową podkategorie');

            return $this->redirect($this->generateUrl(
                'administration_categories'
            ));
        }
        return $this->render('administration/categories.html.twig', array(
            'categories' => $categories,
            'createCategory' => $createCategory->createView(),
            'subcategories' => $subcategories,
            'createSubcategories' => $createSubcategories->createView(),

        ));
    }

    /**
     * @Route("/kategorie/{option}/{type}/{id}", name="administration_categories_option")
     */
    public function categoriesOption(Request $request, $option, $id, $type)
    {
        if ($type == 'kategorie') {
            $category = $this->getDoctrine()->getRepository('App:Categories')->findOneBy(array('id' => $id));
            if ($option == 'edytuj') {
                $editCategories = $this->createForm(CategoriesType::class, $category);
                $editCategories->handleRequest($request);
                if ($editCategories->isSubmitted() && $editCategories->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($category);
                    $em->flush();

                    return $this->redirect($this->generateUrl(
                        'administration_categories'
                    ));
                }
                return $this->render('administration/categoriesEdit.html.twig', array(
                    'editCategories' => $editCategories->createView(),

                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($category);
                $em->flush();
                return $this->redirectToRoute('administration_categories');
            }
        } else {
            $subcategory = $this->getDoctrine()->getRepository('App:Subcategories')->findOneBy(array('id' => $id));
            if ($option == 'edytuj') {
                $editSubcategories = $this->createForm(SubcategoriesType::class, $subcategory);
                $editSubcategories->handleRequest($request);
                if ($editSubcategories->isSubmitted() && $editSubcategories->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($subcategory);
                    $em->flush();
                    return $this->redirect($this->generateUrl(
                        'administration_categories'
                    ));
                }
                return $this->render('administration/subcategoriesEdit.html.twig', array(
                    'editSubcategories' => $editSubcategories->createView(),

                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($subcategory);
                $em->flush();
                return $this->redirectToRoute('administration_categories');
            }
        }
    }

    /**
     * @Route("/samochody", name="administration_car")
     */
    public function car(Request $request)
    {
        $mark = $this->getDoctrine()->getRepository('App:CarMark')->findAll();
        $model = $this->getDoctrine()->getRepository('App:CarModel')->findAll();
        $newMark = new CarMark();
        $createMark = $this->createForm(CarMarkType::class, $newMark);
        $createMark->handleRequest($request);
        if ($createMark->isSubmitted() && $createMark->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newMark);
            $em->flush();
            $this->addFlash('success-mark', 'Dodano nową markę samochodu');

            return $this->redirect($this->generateUrl(
                'administration_car'
            ));
        }
        $newModel = new CarModel();
        $createModel = $this->createForm(CarModelType::class, $newModel);
        $createModel->handleRequest($request);
        if ($createModel->isSubmitted() && $createModel->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newModel);
            $em->flush();
            $this->addFlash('success-model', 'Dodano nowy model samochodu');

            return $this->redirect($this->generateUrl(
                'administration_car'
            ));
        }
        return $this->render('administration/car.html.twig', array(
            'mark' => $mark,
            'createMark' => $createMark->createView(),
            'model' => $model,
            'createModel' => $createModel->createView(),

        ));
    }

    /**
     * @Route("/samochody/{option}/{type}/{id}", name="administration_car_option")
     */
    public function carOption(Request $request, $option, $id, $type)
    {
        if ($type == 'samochód') {
            $carMark = $this->getDoctrine()->getRepository('App:CarMark')->findOneBy(array('id' => $id));
            if ($option == 'edytuj') {
                $editCarMark = $this->createForm(CarMarkType::class, $carMark);
                $editCarMark->handleRequest($request);
                if ($editCarMark->isSubmitted() && $editCarMark->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($carMark);
                    $em->flush();

                    return $this->redirect($this->generateUrl(
                        'administration_car'
                    ));
                }
                return $this->render('administration/carMarkEdit.html.twig', array(
                    'editCarMark' => $editCarMark->createView(),

                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($carMark);
                $em->flush();
                return $this->redirectToRoute('administration_car');
            }
        } else {
            $carModel = $this->getDoctrine()->getRepository('App:CarModel')->findOneBy(array('id' => $id));
            if ($option == 'edytuj') {
                $editCarModel = $this->createForm(CarModelType::class, $carModel);
                $editCarModel->handleRequest($request);
                if ($editCarModel->isSubmitted() && $editCarModel->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($carModel);
                    $em->flush();
                    return $this->redirect($this->generateUrl(
                        'administration_car'
                    ));
                }
                return $this->render('administration/carModelEdit.html.twig', array(
                    'editCarModel' => $editCarModel->createView(),

                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($carModel);
                $em->flush();
                return $this->redirectToRoute('administration_car');
            }
        }
    }

    /**
     * @Route("/strona-glowna", name="administration_main_page")
     */
    public function mainPage(Request $request)
    {
        $photo = $this->getDoctrine()->getRepository('App:MainPagePhoto')->findAll();
        $text = $this->getDoctrine()->getRepository('App:MainPage')->findAll();
        return $this->render('administration/mainPage.html.twig', array(
            'photo' => $photo,
            'text' => $text,
        ));
    }

    /**
     * @Route("/strona-glowna/{option}/{type}/{id}", name="administration_main_page_option")
     */
    public function mainPageOption(Request $request, $option, $type, $id = null)
    {
        $photo = $this->getDoctrine()->getRepository('App:MainPagePhoto')->findOneBy(array('id' => $id));
        if ($type == 'text') {
            $text = $this->getDoctrine()->getRepository('App:MainPage')->findOneBy(array('id' => $id));
            if ($option == 'dodaj') {
                $mainPage = new MainPage();
                $form = $this->createForm(MainPageTextType::class, $mainPage);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($mainPage);
                    $em->flush();
                    $this->addFlash('success', 'Dodano pomyślnie');

                    return $this->redirect($this->generateUrl(
                        'administration_main_page'
                    ));
                }
                return $this->render('administration/mainPageForm.html.twig', array(
                    'mainPage' => $form->createView(),

                ));
            } else {
                if ($option == 'edytuj') {
                    $mainPage = $text;
                    $form = $this->createForm(MainPageTextType::class, $mainPage);
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($mainPage);
                        $em->flush();
                        $this->addFlash('success', 'Edycja zakończona pomyślnie');

                        return $this->redirect($this->generateUrl(
                            'administration_main_page'
                        ));
                    }
                    return $this->render('administration/mainPageForm.html.twig', array(
                        'mainPage' => $form->createView(),

                    ));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($text);
                    $em->flush();
                    $this->addFlash('success', 'Tekst został usunięty');
                    return $this->redirectToRoute('administration_main_page');
                }
            }
        } else {
            if ($option == 'dodaj') {
                $mainPage = new MainPagePhoto();
                $form = $this->createForm(MainPagePhotoType::class, $mainPage);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $uploads_directory = $this->getParameter('uploads_directory');
                    $files = $request->files->get('app_mainPagePhotos')['photo'];
                    foreach ($files as $file) {
                        $name = $file->getClientOriginalName();
                        $fileName[] = $name;
                        $file->move(
                            $uploads_directory,
                            $name
                        );
                    }
                    if ($fileName != null) {
                        foreach ($fileName as $item) {
                            $photo = new MainPagePhoto();
                            $photo->setPhoto($item);
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($photo);
                            $em->flush();
                        }
                    }
                    $this->addFlash('success', 'Dodano pomyślnie');
                    return $this->redirect($this->generateUrl(
                        'administration_main_page'
                    ));
                }
                return $this->render('administration/mainPageForm.html.twig', array(
                    'mainPage' => $form->createView(),
                ));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($photo);
                $em->flush();
                $this->addFlash('success', 'Zdjęcie zostało usunięte');
                return $this->redirectToRoute('administration_main_page');
            }
        }
    }
}