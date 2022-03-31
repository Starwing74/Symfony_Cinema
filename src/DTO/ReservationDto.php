<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\CarteBancaire;
use App\Entity\Reservation;
use Doctrine\Common\Annotations\Annotation\Required;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ReservationDto extends AbstractDto {

    #[Required]
    public CarteBancaire $carte;

    /**
     * @param Reservation $reservation
     */
    public function setFromEntity(AbstractEntity $reservation): void {
    }
}
