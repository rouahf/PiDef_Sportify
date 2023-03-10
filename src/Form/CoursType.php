<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CoursType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_cours',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre nom',
                ],
            ])
            ->add('activite',TextType::class,[
                'label' => 'activite',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre activite',
                ],
            ])
            ->add('date_cours')
            ->add('image', FileType::class ,[
                'data_class' => null,
                'label' => 'Image' ,
                'attr' => ['placeholder' => 'image.jpg',
                'class'=>"form-control-file"]
            ])
            
        ;
    }
   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
