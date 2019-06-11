<?php

namespace App\Form;

use App\Entity\Institution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;




class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('proofOfPurchase', ChoiceType::class, array(
                'label' => 'form.name',
                'attr' => array('class' => 'form-control'),
                'choice_label' => function ($choiceValue, $key, $value) {
                    return $value;
                    },
                'choices' => $options['choice'],
                'required' => true,
            ))
            ->add('price', IntegerType::class, array(
                'label' => 'form.category',
//                'placeholder' => 'form.select_category',
//                'class' => Institution::class,
//                'choice_label' => 'name',
                'attr' => array('class' => 'form-control'),
                'required' => false,

            ))
            ->add('all', SubmitType::class, array('label' => 'shopping_cart.order_all','attr' => array('class' => 'form-control')))
            ->add('individual', SubmitType::class, array('label' => 'shopping_cart.order_separately','attr' => array('class' => 'form-control')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\OrderCart',
            'choice' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_order';
    }

}
