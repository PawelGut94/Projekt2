<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Subcategories;
use App\Repository\SubcategoriesRepository;
use App\Entity\Offer;
use App\Entity\OfferCarMark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class OfferType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'form.name',
                'attr' => array('class' => 'form-control'),
                'required' => true,
            ))
            ->add('description', TextType::class, array(
                'label' => 'form.description',
                'attr' => array('class' => 'form-control'),
                'required' => true,
            ))
            ->add('offerPhotos', CollectionType::class, array(
                'entry_type' => OfferPhotoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'required' => false,
                'allow_delete' => true,
                'attr' => array(
                    'class' => "photo-collection",
                )
            ))
            ->add('price', NumberType::class, array(
                'label' => 'form.price',
                'attr' => array('class' => 'form-control'),
                'required' => true,
            ))
            ->add('category', EntityType::class, array(
                'label' => 'form.category',
                'placeholder' => 'form.select_category',
                'class' => Categories::class,
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('offerCarMark', CollectionType::class, array(
                'label' => 'form.car',
                'entry_type' => OfferCarMarkType::class,
                'allow_add' => true,
                'prototype' => true,
                'required' => false,
                'allow_delete' => true,
                'entry_options' => ['label' => false],
                'attr' => array(
                    'class' => "car-collection",
                )
            ))
            ->add('quantity', IntegerType::class, array(
                'label' => 'form.quantity',
                'attr' => array(
                    'class' => "form-control",
                )
            ))
            ->add('save', SubmitType::class, array('label' => 'Dalej','attr' => array('class' => 'form-control')));

        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $form->getParent()->add('subcategory', EntityType::class, array(
                    'class' => Subcategories::class,
                    'placeholder' => 'form.select_subcategory',
                    'choice_label' => 'name',
                    'choices' => $form->getData()->getSubcategories(),
                    'attr' => array('class' => 'form-control'),

                ));
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $subcategory = $data->getSubcategory();
            if ($subcategory) {
                $form->get('category')->setData($subcategory->getCategory());
                $form->getParent()->add('subcategory', EntityType::class, array(
                    'class' => Subcategories::class,
                    'placeholder' => 'form.select_subcategory',
                    'choice_label' => 'name',
                    'choices' => $form->getData()->getSubcategories(),
                    'attr' => array('class' => 'form-control'),

                ));
            } else {
                $form->add('subcategory', EntityType::class, array(
                    'class' => Subcategories::class,
                    'placeholder' => 'form.select_subcategory',
                    'choice_label' => 'name',
                    'choices' => [],
                    'attr' => array('class' => 'form-control'),

                ));
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
            'data_class' => 'App\Entity\Offer',
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_offer';
    }

}
