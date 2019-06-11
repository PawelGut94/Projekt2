<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class InstitutionPhoneEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', IntegerType::class, array(
                'label' => 'form.number_phone',
                'attr' => array('class' => 'form-control')
            ))
            ->add('delete', SubmitType::class, array('label' => 'form.delete','attr' => array('class' => 'form-control')));


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\InstitutionPhone',
        ));
    }
    public function getBlockPrefix()
    {
        return 'app_offerInstitutionPhone';
    }

}
