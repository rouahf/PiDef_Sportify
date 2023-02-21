<?php

namespace App\Form;

use App\Entity\Panier;
use App\Entity\Product;
use App\Entity\Commande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut',ChoiceType::class,[
                'choices'=>[
                    "Concernant l'utilisateur"=>[
                        'Abondonner'=>'Abondonner',
                        'En cours'=>'En cours',
                        'Payer'=>'Payer',
                    ],
                    "Concernat la livraison"=>[
                        'Livrer'=>'Livrer',
                    ],
                ],
            ])
            ->add('quatite')
            ->add('prixU')
           
            ->add('produit', EntityType::class, [
                'class'=>Product::class,
                'choice_label'=>'name_produits',
               'multiple'=>false,
                'expanded'=>false
            ])
            
            ->add('commande', EntityType::class, [
                'class'=>Commande::class,
                'choice_label'=>'id',
               'multiple'=>false,
                'expanded'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panier::class,
        ]);
    }
}
