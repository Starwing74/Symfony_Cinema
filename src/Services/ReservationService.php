<?php

namespace App\Services;

use App\DTO\AbstractDto;
use App\Entity\AbstractEntity;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\AbstractRepository;
use App\Repository\ReservationRepository;
use App\Repository\SeanceRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class ReservationService extends AbstractEntityService {

    private ReservationRepository $reservationRepository;
    private SeanceRepository $seanceRepository;
    private UserRepository $userRepository;
    private Security $security;

    public function __construct(Security $security ,ReservationRepository $reservationRepository, SeanceRepository $seanceRepository, UserRepository $userRepository) {
        $this->reservationRepository = $reservationRepository;
        $this->seanceRepository = $seanceRepository;
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function createNewReservation(AbstractDto $reservationDto, $data): Reservation {
        $reservation = new Reservation();
        $reservation->setFromDto($reservationDto);
        $reservation->setPrix($data['prixTotal']);
        $seance = $this->seanceRepository->find($data['seance']);
        $reservation->setSeance($seance);
        $user = $this->userRepository->find($this->security->getUser()->getId());
        $reservation->setUser($user);

        $this->reservationRepository->save($reservation);
        return $reservation;
    }
}
