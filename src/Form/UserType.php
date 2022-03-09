<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom', null, array(
                    'attr' => array(
                        'placeholder' => 'Entre votre nom',
                    ))
            )
            ->add('prenom', null, array(
                    'attr' => array(
                        'placeholder' => 'Entre votre prenom',
                    ))
            )
            ->add('adresse', null, array(
                    'attr' => array(
                        'placeholder' => 'Entre votre adresse',
                    ))
            )
            ->add('email', null, array(
                    'attr' => array(
                        'placeholder' => 'Entre votre mail',
                    ))
            )
            ->add('num', null, array(
                    'attr' => array(
                        'placeholder' => 'Entre votre numero',
                    ))
            )
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ])
            ->add('password', PasswordType::class, array(
                    'attr' => array(
                        'placeholder' => 'Entre votre mot passe', 'label' => 'Password'
                    ))
            );
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);

        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
    }
}
