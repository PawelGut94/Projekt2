<?php

namespace App\Form;


use App\Entity\Institution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class AvailabilityOfferType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Institution', EntityType::class, array(
                'label' => 'form.shop',
                'class' => Institution::class,
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('quantity', IntegerType::class, array(
                'required' => true,
                'label' => 'form.quantity',
                'attr' => array('class' => 'form-control'),
            ))
        ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\AvailabilityOffer',
        ));
    }
    public function getBlockPrefix()
    {
        return 'app_availabilityOffer';
    }




}
