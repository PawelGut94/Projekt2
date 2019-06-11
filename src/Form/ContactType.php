<?php

namespace App\Form;

use App\Entity\Institution;
use App\Entity\InstitutionPhone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', ChoiceType::class, array(
                'label' => false,
                'choices' => $options['city'],
                'choice_label' => function ($choiceValue, $key, $value) {
                    return $value;
                },
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'form.search',
                'attr' => array('class' => 'form-control')

            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Institution',
            'city' => null,
        ));
    }
    public function getBlockPrefix()
    {
        return 'app_contact';
    }

}
