<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class searchType extends AbstractType
    {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_cours',null, [
                'attr' => [
                    'placeholder' => 'nom_cours',
                ]])
        ;
    }
//,ChoiceType::class, [
//'choices' => [
//'Validé' => 'Valide',
//'Proposition' => 'Proposition',
//]]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}