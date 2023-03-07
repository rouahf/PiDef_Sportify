<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference')
            ->add('fullname')
            ->add('transportName')
            ->add('transportPrice')
            ->add('livraisonAdresse')
            ->add('isPaid')
            ->add('moreInformations')
            ->add('quantity')
            ->add('subTotalHT')
            ->add('taxe')
            ->add('subTotalTTC')
            ->add('stripeSessionId')
            ->add('user', EntityType::class, [
                'class'=>User::class,
                 'choice_label'=>'email',
                'multiple'=>false,
                 'expanded'=>false
             ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
