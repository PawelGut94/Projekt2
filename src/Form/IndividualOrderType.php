<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class IndividualOrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', IntegerType::class, array(
                'required' => true,
                'label' => 'form.quantity',
                'attr' => array('class' => 'form-control','min' => 0),
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'form.add_to_shopping_cart',
                'attr' => array('class' => 'btn btn-success')
            ));;
        ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Offer',
            'shop' => null,
        ));
    }
    public function getBlockPrefix()
    {
        return 'app_individualOrder';
    }




}
