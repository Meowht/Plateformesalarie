<?php

namespace App\Form;

use App\Entity\UploadImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\File;

class UploadImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('UploadedImage', FileType::class, [
                'attr' => [
                    'accept' => "image/*",   
                ],
                'constraints' => [
                    new Image([
                        'mimeTypes' => ["image/jpeg", "image/png"],
                        'mimeTypesMessage' => "Ce n'est pas le bon format ! Il n'y a  qu'une image au format JPEG ou PNG  qui est accepté ! ",
                        
                        
                    ]),
                    new File([
                        'maxSize' => '5M', // Taille maximale du fichier
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UploadImage::class,
        ]);
    }
}