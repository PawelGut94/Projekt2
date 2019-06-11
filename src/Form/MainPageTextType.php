<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class MainPageTextType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'form.title',
                'attr' => array('class' => 'form-control'),
                'required' => true,
            ))
            ->add('text', TextType::class, array(
                'label' => 'form.name',
                'attr' => array('class' => 'form-control form-text-main-page'),
                'required' => true,
            ))
            ->add('save', SubmitType::class, array('label' => 'admin.save','attr' => array('class' => 'form-control')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\MainPage',
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_mainPageText';
    }

}
