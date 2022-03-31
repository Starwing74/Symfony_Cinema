<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RajouterFilmFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, ['label' => 'Name :'])
            ->add('Image', TextType::class, ['label' => 'Image :'])
            ->add('Resumer', TextType::class, ['label' => 'Resumer :'])
            ->add('Durer', TextType::class, ['label' => 'Durer :'])
            ->add('Directeur', TextType::class, ['label' => 'Directeur :'])
            ->add('BandeAnnonce', TextType::class, ['label' => 'Bande annonce lien yt:'])
            ->add('Categorie',ChoiceType::class,
                array('choices' => array(
                    'Comédie' => 'Comédie',
                    'Thriller/Film' => 'Thriller/Film',
                    'Action/Aventure' => 'Action/Aventure',
                    'Romance/Comédie' => 'Romance/Comédie',
                    'Drame' => 'Drame'),
                    'multiple'=>false,'expanded'=>true));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RajouterFilmDTO::class,
        ]);
    }
}