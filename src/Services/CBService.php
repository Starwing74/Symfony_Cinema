<?php

namespace App\Services;

use App\DTO\AbstractDto;
use App\Entity\AbstractEntity;
use App\Entity\CarteBancaire;
use App\Entity\User;
use App\Repository\AbstractRepository;
use App\Repository\CarteBancaireRepository;

class CBService extends AbstractEntityService {

    private CarteBancaireRepository $cbRepository;

    public function __construct(CarteBancaireRepository $cbRepository) {
        $this->cbRepository = $cbRepository;
    }

    public function enterNewCarteBancaire(AbstractDto $cbDto, User $user): CarteBancaire {
        $cb = new CarteBancaire($user);
        $cb->setFromDto($cbDto);
        $this->cbRepository->save($cb);
        return $cb;
    }
}
