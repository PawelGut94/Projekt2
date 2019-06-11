<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferAddPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('save', SubmitType::class, array('label' => 'admin.save','attr' => array('class' => 'form-control')));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Offer'
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_offerPhotos';
    }


}