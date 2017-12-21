<?php

namespace App\Form;

use App\Entity\Fortune;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FortuneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'content', TextareaType::class, ['required' => TRUE, 'label' => 'Your story:'])
            ->add( 'save', SubmitType::class, ['label' => 'Save a new fortune!'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Fortune::class,
        ]);
    }
}
