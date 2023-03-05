<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('categories', EntityType::class,[
            'class' => Categories::class,
            'label' => true,
            'multiple' => true,
            'expanded'=>true,
            'attr' => [
                'class' => 'js-categories-multiple'
            ]
        ])
        ->add('minprice', IntegerType::class,[
            'required' => false,
            'label' => false,
            'attr' => [
                'placeholder' => 'min ...'
            ]

        ])
        ->add('maxprice', IntegerType::class,[
            'required' => false,
            'label' => false,
            'attr' => [
                'placeholder' => 'max ...'
            ]

        ])
        
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
