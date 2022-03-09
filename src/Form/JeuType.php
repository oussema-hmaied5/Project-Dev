<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Jeu;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('entreprise')
            ->add('type',ChoiceType::class,array('choices'=>array(
                'Online'=>'Online',
                'Offline'=>'Offline')
            ))
            ->add('genre',ChoiceType::class,array('choices'=>array(
                'Solo'=>'Solo',
                'Multiplayer'=>'Multiplayer')
     ))
             ->add('category', EntityType::class, ['class' => category::class, 'choice_label' => 'titre', 'label' => 'catégorie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }

    private function add(string $string, string $class, array $array)
    {
    }
}
