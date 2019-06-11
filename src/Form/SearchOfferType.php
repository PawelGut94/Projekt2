<?php

namespace App\Form;

use App\Entity\CarMark;
use App\Entity\CarModel;
use App\Entity\Categories;
use App\Entity\Subcategories;
use App\Repository\SubcategoriesRepository;
use App\Entity\Offer;
use App\Entity\OfferCarMark;
use App\Entity\SearchOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SearchOfferType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'form.name',
//                'data' => $options['ajax'],
                'attr' => array('class' => 'form-control'),
                'required' => false,
            ))
            ->add('category', EntityType::class, array(
                'label' => 'form.category',
                'placeholder' => 'form.all',
                'class' => Categories::class,
                'choice_label' => 'name',
                'required' => false,
                'attr' => array('class' => 'form-control'),
            ))
            ->add('mark', EntityType::class, array(
                'label' => 'form.mark',
                'placeholder' => 'form.all',
                'class' => CarMark::class,
                'choice_label' => 'name',
                'required' => false,
                'attr' => array('class' => 'form-control'),
            ))
            ->add('save', SubmitType::class, array('label' => 'form.search','attr' => array('class' => 'form-control')));;
        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                if ($form->getData() == null) {
                } else {
                    $form->getParent()->add('subcategory', EntityType::class, array(
                        'class' => Subcategories::class,
                        'placeholder' => 'form.all',
                        'label' => 'form.subcategory',
                        'required' => false,
                        'choice_label' => 'name',
                        'choices' => $form->getData()->getSubcategories(),
                        'attr' => array('class' => 'form-control'),

                    ));
                }
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $subcategory = $data->getSubcategory();
            if($data->getSelectSubcategory())
            {
                if ($subcategory) {
                    $form->get('category')->setData($subcategory->getCategory());
                    $form->add('subcategory', EntityType::class, array(
                        'class' => Subcategories::class,
                        'placeholder' => 'form.select_subcategory',
                        'choice_label' => 'name',
                        'label' => 'form.subcategory',
                        'required' => false,
                        'choices' => $subcategory->getCategory()->getSubcategories(),
                        'attr' => array('class' => 'form-control'),

                    ));
                } else {
                    $form->add('subcategory', EntityType::class, array(
                        'class' => Subcategories::class,
                        'placeholder' => 'form.select_subcategory',
                        'label' => 'form.all',
                        'choice_label' => 'name',
//                    'data' =>null,

                        'required' => false,
                        'choices' => [],
                        'attr' => array('class' => 'form-control'),

                    ));
                }
            }else
            {
                if ($subcategory) {
                    $form->get('category')->setData($subcategory->getCategory());
                    $form->add('subcategory', EntityType::class, array(
                        'class' => Subcategories::class,
                        'placeholder' => 'form.all',
                        'choice_label' => 'name',
                        'label' => 'form.subcategory',
                        'data' =>null,
                        'required' => false,
                        'choices' => $subcategory->getCategory()->getSubcategories(),
                        'attr' => array('class' => 'form-control'),

                    ));
                } else {
                    $form->add('subcategory', EntityType::class, array(
                        'class' => Subcategories::class,
                        'placeholder' => 'form.all',
                        'label' => 'form.subcategory',
                        'choice_label' => 'name',
                        'disabled' => true,
                        'required' => false,
                        'choices' => [],
                        'attr' => array('class' => 'form-control'),

                    ));
                }
            }

        }
        );


        $builder->get('mark')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                if ($form->getData() == null) {
                } else {
                    $form->getParent()->add('model', EntityType::class, array(
                        'class' => CarModel::class,
                        'placeholder' => 'form.select_subcategory',
                        'label' => 'form.model',
                        'required' => false,
                        'choice_label' => 'name',
                        'choices' => $form->getData()->getCarModel(),
                        'attr' => array('class' => 'form-control'),

                    ));
                }
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $model = $data->getModel();
            if($data->getSelectModel())
            {
                if ($model) {
                    $form->get('mark')->setData($model->getMark());
                    $form->add('model', EntityType::class, array(
                        'class' => CarModel::class,
                        'placeholder' => 'form.select_subcategory',
                        'choice_label' => 'name',
                        'label' => 'form.model',
                        'required' => false,

//                    'disabled' => true,
                        'choices' => $model->getMark()->getCarModel(),
                        'attr' => array('class' => 'form-control'),

                    ));
                } else {
                    $form->add('model', EntityType::class, array(
                        'class' => CarModel::class,
                        'placeholder' => 'form.select_subcategory',
                        'label' => 'form.model',
                        'choice_label' => 'name',
                        'required' => false,

                        'choices' => [],
                        'attr' => array('class' => 'form-control'),

                    ));
                }
            }
            else
            {
                if ($model) {
                    $form->get('mark')->setData($model->getMark());
                    $form->add('model', EntityType::class, array(
                        'class' => CarModel::class,
                        'placeholder' => 'form.all',
                        'choice_label' => 'name',
                        'label' => 'form.model',
                        'required' => false,
                        'data' => null,
                        'choices' => $model->getMark()->getCarModel(),
                        'attr' => array('class' => 'form-control'),

                    ));
                } else {
                    $form->add('model', EntityType::class, array(
                        'class' => CarModel::class,
                        'placeholder' => 'form.all',
                        'label' => 'form.model',
                        'choice_label' => 'name',
                        'required' => false,
                        'disabled' => true,
                        'choices' => [],
                        'attr' => array('class' => 'form-control'),

                    ));
                }
            }

        }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\SearchOffer',
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_offer2';
    }

}
