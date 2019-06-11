<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;



class EditUserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'profile.name',
                'required' => true,

                'attr' => array(
                    'class' => 'form-control',

                )
            ))
            ->add('surname', TextType::class, array(
                'label' => 'profile.surname',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',

                )
            ))
            ->add('email', TextType::class, array(
                'label' => 'profile.email',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',

                )
            ))
            ->add('NIP', TextType::class, array(
                'label' => 'profile.nip',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',

                )
            ))
            ->add('address', TextType::class, array(
                'label' => 'profile.address',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',

                )
            ))
            ->add('zipCode', TextType::class, array(
                'label' => 'profile.zip_code',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',

                )
            ))
            ->add('clientNumber', IntegerType::class, array(
                'label' => 'profile.client_number',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',

                )
            ))
            ->add('rodo', CheckboxType::class, array(
                'required' => true,
                'label' => false,
            ))
            ->add('save', SubmitType::class, array('label' => 'admin.save','attr' => array('class' => 'form-control')));;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\User',
        ));
    }


}
