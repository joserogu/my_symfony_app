<?php

namespace App\Form;

use App\Entity\PersonaEntityUpload;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PersonaUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('email', TextType::class)
            ->add('telefono', TextType::class)
            ->add('pais', ChoiceType::class, [
                'choices' => [
                    'España' => 1,
                    'Francia' => 2,
                    'Portugal' => 3,
                    'Italia' => 4,
                    'Grecia' => 5,
                    'Alemania' => 6,
                    'Reino Unido' => 7,
                    'Suecia' => 8,
                ],
                'placeholder' => 'Seleccione un país',
            ])
            ->add('foto', FileType::class, ['mapped'=> true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonaEntityUpload::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
        ]);
    }
}
