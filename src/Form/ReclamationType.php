<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service', null, array(
                    'attr' => array(
                        'placeholder' => 'Entre nom service',
                    ))
            )


            ->add('sujet', null, array(
                    'attr' => array(
                        'placeholder' => 'Entre sujet de reclamation',
                    ))
            )
            ->add('user', EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'id',
                'disabled' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);

        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
    }
}
