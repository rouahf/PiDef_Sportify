<?php

namespace App\Form;

use App\Entity\Priorite;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrioriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
           
            ->add('id_type', EntityType::class, [
                'class'=>type::class,
                 'choice_label'=>'nom_type',
                'multiple'=>false,
                 'expanded'=>false
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Priorite::class,
        ]);
    }
}
