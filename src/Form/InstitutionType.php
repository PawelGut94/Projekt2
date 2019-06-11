<?php

namespace App\Form;

use App\Entity\Institution;
use App\Entity\InstitutionPhone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class InstitutionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class, array(
                'label' => 'Miasto',
                'attr' => array('class' => 'form-control')
            ))
            ->add('address', TextType::class, array(
                'label' => 'Adres',
                'attr' => array('class' => 'form-control')
            ))
            ->add('zipCode', TextType::class, array(
                'label' => 'Kod pocztowy',
                'attr' => array('class' => 'form-control')
            ))
            ->add('email', EmailType::class, array(
                'label' => 'e-mail',
                'attr' => array('class' => 'form-control')
            ))
            ->add('institutionPhones', CollectionType::class, array(
                'label' => 'form.contact',
                'entry_type' => InstitutionPhoneType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,

                'attr' => array(
                    'class' => "phone-collection",
                )
            ))
            ->add('save', SubmitType::class, array('label' => 'form.save','attr' => array('class' => 'form-control')));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Institution',
        ));
    }
    public function getBlockPrefix()
    {
        return 'app_offerInstitution';
    }

}
