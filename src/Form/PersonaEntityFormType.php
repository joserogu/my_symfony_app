<?php

namespace App\Form;

use App\Entity\PersonaEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PersonaEntityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label'=>'Nombre'])
            ->add('email', TextType::class, ['label'=>'E-Mail'])
            ->add('telefono', TextType::class, ['label'=>'Telelfono'])
            ->add('pais', ChoiceType::class, [
                'label'=>'País',
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
        $resolver->setDefaults(
            [
            'data_class' => PersonaEntity::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            ]);
    }
}
