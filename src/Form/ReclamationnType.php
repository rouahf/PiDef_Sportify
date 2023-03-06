<?php

namespace App\Form;

use App\Entity\Reclamationn;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ReclamationnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idUser')
            ->add('email')
            ->add('categorie')
            ->add('etat_reclamation')
            ->add('priorite')
           // ->add('captcha',Recaptcha3Type::class,[
            //   'constraints' => new Recaptcha3(),
             //   'action_name' => 'reclamationn',
          //  ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamationn::class,
        ]);
    }
}
