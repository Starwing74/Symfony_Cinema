<?php

namespace App\Form;

use App\DTO\ReservationDto;
use App\Repository\CarteBancaireRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ReservationType extends AbstractType
{
    private $security;
    private EntityManagerInterface $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    private function getAllCreditCards()
    {
        $cbr = $this->em->getRepository('App\Entity\CarteBancaire');
        $user_id = $this->security->getUser()->getId();
        $qb = $cbr->createQueryBuilder('f')
            ->where(":user_id = f.user")
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult();
        return $qb;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('carte', ChoiceType::class, [
                'choices' => $this->getAllCreditCards(),
                'choice_label' => function ($choice, $key, $value) {
                    return 'carte ************'. $choice->getNumeroCarteDiscret() . ' arrivant à expiration en ' . $choice->getDateExpirationString();
                },
                'expanded' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationDto::class,
            'required' => false
        ]);
    }


}
