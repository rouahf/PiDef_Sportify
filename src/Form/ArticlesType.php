<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\CategorieA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre_Article')
            ->add('contenu_Article')
            ->add('auteur_Article')
            ->add('image_article', FileType::class ,[
                'data_class' => null,
                'label' => 'Image' ,
                'attr' => ['placeholder' => 'image.jpg',
                'class'=>"form-control-file"]
            ])
            
            ->add('id_categA', EntityType::class, [
                'class'=>CategorieA::class,
                 'choice_label'=>'typeA',
                'multiple'=>false,
                 'expanded'=>false
             ])
            
        ;
        
}
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
