<?php

namespace App\Repository;

use App\Entity\CarteBancaire;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarteBancaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarteBancaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarteBancaire[]    findAll()
 * @method CarteBancaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteBancaireRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteBancaire::class);
    }
}
