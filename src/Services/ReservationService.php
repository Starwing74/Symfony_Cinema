<?php

namespace App\Services;

use App\DTO\AbstractDto;
use App\Entity\AbstractEntity;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\AbstractRepository;
use App\Repository\ReservationRepository;

class ReservationService extends AbstractEntityService {

    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository) {
        $this->reservationRepository = $reservationRepository;
    }

    public function createNewReservation(AbstractDto $reservationDto, $data): Reservation {
        $reservation = new Reservation();
        $reservation->setFromDto($reservationDto);
        $reservation->setPrix($data->prix);
        $reservation->setSeance($data->seance);
        $this->reservationRepository->save($reservation);
        return $reservation;
    }
}
