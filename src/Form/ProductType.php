<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameProduct')
            ->add('description')
            ->add('moreInformations')
            ->add('price')
            ->add('isBest')
            ->add('isNew')
            ->add('isFeatured')
            ->add('isSpecialOffer')
            ->add('image', FileType::class ,[
                'data_class' => null,
                'label' => 'Image' ,
                'attr' => ['placeholder' => 'image.jpg',
                'class'=>"form-control-file"]
            ])
            ->add('quantity')
            ->add('tags')
            ->add('slug')
            ->add('category', EntityType::class, [
                'class'=>Categories::class,
                 'choice_label'=>'name_categorie',
                'multiple'=>false,
                 'expanded'=>false
             ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
