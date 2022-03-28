<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Prenom', TextType::class, ['label' => 'Prenom :'])
            ->add('Nom', TextType::class, ['label' => 'Name :'])
            ->add('Mail', EmailType::class, ['label' => 'Mail :'])
            ->add('Password', PasswordType::class, ['label' => 'Password :'])
            ->add('answer1',ChoiceType::class,
                array('choices' => array(
                    'answer1' => '1',
                    'answer2' => '2',
                    'answer3' => '3',
                    'answer4' => '4'),
                    'choices_as_values' => true,'multiple'=>false,'expanded'=>true));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InscriptionDTO::class,
        ]);
    }
}