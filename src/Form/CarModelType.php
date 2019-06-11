<?php

namespace App\Form;

use App\Entity\CarMark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class CarModelType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', EntityType::class, array(
                'label' => 'admin.car_mark',
                'placeholder' => 'form.select_mark',
                'class' => CarMark::class,
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('name', TextType::class, array(
                'label' => 'admin.car_model',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
        ->add('save', SubmitType::class, array('label' => 'admin.save','attr' => array('class' => 'form-control')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\CarModel',
        ));
    }


}
