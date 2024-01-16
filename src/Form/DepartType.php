<?php

namespace App\Form;

use App\Entity\Depart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;

class DepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', null, [
                'label' => 'Nom : ',
                'attr' => [
                    'class' => 'mb-3', // Ajoute une marge inférieure
                ],
                'constraints' => [
                    new Length(['min' => 3,
                'minMessage' => 'Ce champ doit avoir au moins {{ limit }} caractères minimum.',]), // ajoute une contrainte qui me permet d'ajouter une limite à trois caractères. Je peux changer le nombre que je souhaite
                ],
            ])
            ->add('Prenom', null, [
                'label' => 'Prénom : ',
                'attr' => [
                    'class' => 'mb-3', // Ajoute une marge inférieure
                ],
                'constraints' => [
                    new Length(['min' => 3,
                    'minMessage' => 'Ce champ doit avoir au moins {{ limit }} caractères minimum.',
                ]), // ajoute une contrainte qui me permet d'ajouter une limite à trois caractères. Je peux changer le nombre que je souhaite
                ],
            ])
            // ceci me permet de customiser mon input pour lui donner un choix parmi certains prédéfini pour éviter d'avoir à réécrire la profession 
            ->add('profession', ChoiceType::class, [
                'label' => 'Profession : ',
                'choices' => [
                    'Aide-soignant(e)' => '1',
                    'Infirmier(ère)' => '2',
                    'Agent de service hospitalier (ASH)' => '3',
                    'Animateur(trice)' => '4',
                    'Cuisinier(ère)' => '5',
                    'Technicien(ne) de maintenance' => '6',
                    'Responsable administratif(ve)' => '7',
                    'Médecin coordinateur' => '8',
                    'Cadre de santé' => '9',
                    'Psychologue' => '10',
                    'Résident(e)' => '11',

                ],
                'multiple' => true, // Permet la sélection multiple
                'attr' => [
                    'class' => 'form-select', // Ajoutez la classe pour le style Bootstrap 
                    'id' => 'Select', // Ajoutez un identifiant
                ],
                'label_attr' => [
                    'class' => 'mb-3', // Ajoute une marge inférieure à l'étiquette
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depart::class,
        ]);
    }
}
