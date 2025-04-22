<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\PersonaEntityValidation;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PersonaValidationType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonaEntityValidation::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
        ]);
    }
}
