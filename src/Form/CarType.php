<?php

namespace App\Form;

use App\Entity\CarMark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class CarType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model', null, array(
            'attr' => array('multiple' => true),
            'required' => false,
            'label' => 'menu.contact.city'))
            ->add('mark', TextType::class, array('attr' => array('class' => 'form-control')))


        ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\CarMark',
        ));
    }
    public function getBlockPrefix()
    {
        return 'app_car';
    }




}
