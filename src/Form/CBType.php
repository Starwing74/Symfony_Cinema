<?php

namespace App\Form;

use App\DTO\CBDto;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CBType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero_carte', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 16 , 'max' => 16]),

                ]
            ])
            ->add('cvc', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 3 , 'max' => 3])
                ],
            ])
            ->add('date_expiration', DateType::class, array(
                'format' => 'dd-MM-yyyy',
                'widget' => 'choice',
                'html5' => false,
                'attr' => array(
                    'placeholder' => '03/22',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CBDto::class,
            'required' => false
        ]);
    }
}
