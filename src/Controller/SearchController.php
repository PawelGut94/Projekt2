<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\CarMark;
use App\Entity\SearchOffer;
use App\Form\SearchOfferType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     * @Route("/szukaj/{category}/{subcategory}/{selectedSubcategories}", name="mainSearch")
     */
    public function index(Request $request, $category = null, $subcategory = null, $selectedSubcategories = null)
    {
        $name = $request->query->get('name');
        $mark = $request->query->get('mark');
        $model = $request->query->get('model');
        if ($subcategory == null) {
            $subcategory = $request->query->get('subcategory');
        }
        if ($category == null) {
            $category = $request->query->get('category');
        }
        if($selectedSubcategories == null)
        {
            $selectedSubcategories = $request->query->get('selectedSubcategories');
        }
        $selectedModel = $request->query->get('selectedModel');
        $criteria = $request->query->get('kryteria');
        $search = explode(" ", $criteria);
        $search = array_filter($search);
        $markDetails = null;
        $modelDetails = null;
        $searchModelDetails = null;
        $typeModel = null;
        $searchDetails = false;
        if ($search == null) {
            $searchDetails = true;
        }
        if ($searchDetails == false) {
            foreach ($search as $item) {
                if ($mark == null) {
                    $mark = $this->getDoctrine()->getRepository('App:CarMark')->findOneBy(array('name' => $item));
                    if ($mark != null) {
                        $markDetails = $item;
                    }
                }
                if ($model == null) {
                    $model = $this->getDoctrine()->getRepository('App:CarModel')->findModel($item);
                    if ($model != null) {
                        $model = $item;
                        $searchModelDetails = 1;
                        $modelDetails = $model;
                    }
                }
                if ($searchModelDetails == 1 and $item != $model) {
                    $searchModel = $model . ' ' . $item;
                    $fullNameModel = $this->getDoctrine()->getRepository('App:CarModel')->findOneBy(array('name' => $searchModel));
                    if ($fullNameModel == null) {
                        $modelDetails = $model;
                    } else {
                        $modelDetails = $searchModel;
                        $typeModel = $item;
                    }
                    $searchModelDetails = null;
                }
            }
            if ($markDetails == null and $modelDetails == null) {
                $car = null;
            } else {
                $keyMark = array_search($markDetails, $search);
                $keyModel = array_search($modelDetails, $search);
                $keyModelName = array_search($model, $search);
                $keyModelType = array_search($typeModel, $search);
                if ($modelDetails == null or $markDetails == null) {
                    if ($modelDetails == null) {
                        $car = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('mark' => $mark));
                        unset($search[$keyMark]);

                    } else {
                        $car = $this->getDoctrine()->getRepository('App:CarModel')->findModel($modelDetails);
                        if ($car == null) {
                            $car = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('name' => $modelDetails));
                            unset($search[$keyModelName]);
                            unset($search[$keyModelType]);
                        } else {
                            unset($search[$keyModel]);
                        }
                    }
                } else {
                    $car = $this->getDoctrine()->getRepository('App:CarModel')->findModel($modelDetails);
                    if ($car == null) {
                        $car = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('name' => $modelDetails));
                        unset($search[$keyModelName]);
                        unset($search[$keyModelType]);
                    } else {
                        unset($search[$keyModel]);
                    }
                    unset($search[$keyMark]);
                }
            }
        } else {
            if ($mark == null and $model == null) {
                $car = null;
            } else {
                $findMark = $this->getDoctrine()->getRepository('App:CarMark')->findBy(array('name' => $mark));
                if ($model == null) {
                    $car = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('mark' => $findMark));
                } else {
                    $car = $this->getDoctrine()->getRepository('App:CarModel')->findBy(array('mark' => $findMark, 'name' => $model));
                }
            }
        }
        if ($name == null) {
            $name = implode(" ", $search);
        }
        if ($name == null and $car == null) {
            $offer = $this->getDoctrine()->getRepository('App:OfferCarModel')->findAll();
        } else {
            if ($name == null or $car == null) {
                if ($name == null) {
                    $allOffer = [];
                    foreach ($car as $item) {
                        $offer = $this->getDoctrine()->getRepository('App:OfferCarModel')->findBy(array('carModel' => $item));
                        foreach ($offer as $item) {
                            $allOffer[] = $item;
                        }
                    }
                    $offer = $allOffer;
                } else {
                    $searchOffer = $this->getDoctrine()->getRepository(Offer::class)->findOffer($name);
                    $offer = $this->getDoctrine()->getRepository('App:OfferCarMark')->findBy(array('offer' => $searchOffer));
                }
            } else {
                $searchOffer = $this->getDoctrine()->getRepository(Offer::class)->findOffer($name);
                $allOffer = [];
                foreach ($car as $item) {
                    $offer = $this->getDoctrine()->getRepository('App:OfferCarModel')->findBy(array('carModel' => $item, 'offer' => $searchOffer));
                    foreach ($offer as $item) {
                        $allOffer[] = $item;
                    }
                    $offer = $allOffer;
                }

            }
        }
        foreach ($offer as $item) {
            $searchOffer = $item->getOffer();
            $delete = 0;
            foreach ($offer as $item) {
                if ($searchOffer == $item->getOffer()) {
                    $delete = $delete + 1;
                }
                if ($delete >= 2) {
                    $keyOffer = array_search($item, $offer);
                    unset($offer[$keyOffer]);
                    $delete = 1;
                }
            }
        }
        if ($category != null) {
            $finishedOffers = null;
            $findCategory = $this->getDoctrine()->getRepository('App:Categories')->findOneBy(array('name' => $category));
            if ($subcategory != null) {
                foreach ($offer as $item) {
                    $findSubcategory = $this->getDoctrine()->getRepository('App:Subcategories')->findOneBy(array('name' => $subcategory, 'category' => $findCategory));
                    $findOffer = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $item->getOffer()->getId(), 'category' => $findCategory, 'subcategory' => $findSubcategory));
                    if ($findOffer != null) {
                        $finishedOffers[] = $item;
                    }
                }
            } else {
                foreach ($offer as $item) {
                    $findOffer = $this->getDoctrine()->getRepository('App:Offer')->findOneBy(array('id' => $item->getOffer()->getId(), 'category' => $findCategory));
                    if ($findOffer != null) {
                        $finishedOffers[] = $item;
                    }
                }
            }
            $offer = $finishedOffers;
        }

        $searchOffer = new SearchOffer();
        if ($name != null) {
            $searchOffer->setName($name);
        }
        if ($category != null) {
            $searchCategory = $this->getDoctrine()->getRepository('App:Categories')->findOneBy(array('name' => $category));
            $searchOffer->setCategory($searchCategory);
            if ($selectedSubcategories == true) {
                $searchSubcategories = $this->getDoctrine()->getRepository('App:Subcategories')->findOneBy(array('name' => $subcategory, 'category' => $searchCategory));
                $searchOffer->setSubcategory($searchSubcategories);
                $searchOffer->setSelectSubcategory(true);
            } else {
                $searchSubcategories = $this->getDoctrine()->getRepository('App:Subcategories')->findOneBy(array('category' => $searchCategory));
                $searchOffer->setSubcategory($searchSubcategories);
                $searchOffer->setSelectSubcategory(false);
            }
        }
        if($markDetails != null)
        {
            $mark = $markDetails;
        }
        if ($mark != null) {
            $searchMark = $this->getDoctrine()->getRepository('App:carMark')->findOneBy(array('name' => $mark));
            $searchOffer->setMark($searchMark);
            if ($selectedModel == true) {
                $searchModel = $this->getDoctrine()->getRepository('App:carModel')->findOneBy(array('mark' => $searchMark, 'name' => $model));
                $searchOffer->setModel($searchModel);
                $searchOffer->setSelectModel(true);
            } else {
                $searchModel = $this->getDoctrine()->getRepository('App:carModel')->findOneBy(array('mark' => $searchMark));
                $searchOffer->setModel($searchModel);
                $searchOffer->setSelectModel(false);
            }
        }
        $formSearch = $this->createForm(SearchOfferType::class, $searchOffer);
        if ($request->isMethod('POST')) {
            $formSearch->handleRequest($request);
            if ($formSearch->isSubmitted() && $formSearch->isValid()) {
                $name = $searchOffer->getName();
                $category = $searchOffer->getCategory()->getName();
                $subcategory = $searchOffer->getSubcategory()->getName();
                $selectedSubcategories = true;
                $mark = $searchOffer->getMark()->getName();
                $model = $searchOffer->getModel()->getName();
                $selectedModel = true;
                return $this->redirect($this->generateUrl(
                    'mainSearch', array('name' => $name, 'category' => $category, 'subcategory' => $subcategory, 'mark' => $mark, 'model' => $model, 'selectedSubcategories' => $selectedSubcategories, 'selectedModel' => $selectedModel)
                ));
            } else {
                if ($formSearch->get('save')->isClicked()) {
                    $name = $searchOffer->getName();
                    if ($searchOffer->getCategory() != null) {
                        $category = $searchOffer->getCategory()->getName();
                    } else {
                        $category = null;
                    }
                    if ($searchOffer->getSubcategory() != null) {
                        $subcategory = $searchOffer->getSubcategory()->getName();
                        $selectedSubcategories = true;
                    } else {
                        $subcategory = null;
                        $selectedSubcategories = false;
                    }
                    if ($searchOffer->getMark() != null) {
                        $mark = $searchOffer->getMark()->getName();
                    } else {
                        $mark = null;
                    }
                    if ($searchOffer->getModel() != null) {
                        $model = $searchOffer->getModel()->getName();
                        $selectedModel = true;
                    } else {
                        $model = null;
                        $selectedModel = false;
                    }
                    return $this->redirect($this->generateUrl(
                        'mainSearch', array('name' => $name, 'category' => $category, 'subcategory' => $subcategory, 'mark' => $mark, 'model' => $model, 'selectedSubcategories' => $selectedSubcategories, 'selectedModel' => $selectedModel)
                    ));
                }
            }
        }
        return $this->render('assortmentPage/search_assortment.html.twig', array(
            'search' => $offer,
            'searchOffer' => $formSearch->createView(),

        ));
    }
}