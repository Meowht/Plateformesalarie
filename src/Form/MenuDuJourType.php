<?php

namespace App\Form;

use App\Entity\MenuDuJour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuDuJourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Entree')
            ->add('Proteine')
            ->add('Accompagnement')
            ->add('Dessert')
            ->add('Entree_Soir')
            ->add('Proteine_Soir')
            ->add('Accompagnement_Soir')
            ->add('Dessert_Soir')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MenuDuJour::class,
        ]);
    }
}
