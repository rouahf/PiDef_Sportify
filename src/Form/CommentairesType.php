<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Commentaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_c')
            ->add('email_C')
            ->add('contenu_C')
            /* ->add('id_article', EntityType::class, [
                'class'=>Articles::class,
                 'choice_label'=>'titre_article',
                'multiple'=>false,
                 'expanded'=>false
             ])
           
         */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
