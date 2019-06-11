<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainPagePhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', FileType::class, array(
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'attr' => array(


                )
            ))
            ->add('save', SubmitType::class, array('label' => 'admin.save','attr' => array('class' => 'form-control')));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\MainPagePhoto'
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_mainPagePhotos';
    }


}