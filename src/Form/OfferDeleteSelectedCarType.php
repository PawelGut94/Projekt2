<?php

namespace App\Form;

use App\Entity\CarMark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class OfferDeleteSelectedCarType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', EntityType::class, array(
                'label' => 'admin.car_mark',
                'placeholder' => 'form.select_mark',
                'class' => CarMark::class,
                'disabled' => true,
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('name', ChoiceType::class, array(
                'label' => 'admin.car_model',
                'choices' => $options['model'],
                'choice_label' => 'name',
//                'data' => 1,
                'multiple' => true,
                'required' => true,
                'expanded' => true,
                'mapped' => false,
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
            'model' => null,
        ));
    }


}
