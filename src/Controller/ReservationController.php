<?php

namespace App\Controller;

use App\DTO\ReservationDto;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Services\ReservationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/reservation")]
class ReservationController extends AbstractController
{
    private ReservationService $reservationService;
    private EntityManagerInterface $entityManager;

    public function __construct(ReservationService $reservationService, EntityManagerInterface $entityManager) {
        $this->reservationService = $reservationService;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_reservation')]
    public function index(): Response
    {
        $user = $this->getUser();
        $reservations = $user->getReservations();
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'reservations' => $reservations
        ]);
    }

    #[Route("/complete", name: "reservation.complete", methods: ["GET", "POST"])]
    public function completerReservation(Request $request): Response
    {
        $reservationDto = new ReservationDto();

        $form = $this->createForm(ReservationType::class, $reservationDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($request->getSession());
            $data = 'test'; // DETERMINER COMMENT PASSER DE LA DATA DEPUIS LE TUNNEL
            $reservation = $this->reservationService->createNewReservation($reservationDto, $data);

            $siegeRepository = $this->entityManager->getRepository('App\Entity\Siege');
            foreach ($data->sieges as $siege){
                $reservation->addSiege($siege);
                $siege->setStatus('pris');
                $siegeRepository->save($siege);
            }

            $this->addFlash('success', 'Reservation faite!');

            return $this->redirectToRoute('reservation.recap', [
                'reservation_data' => $reservation
            ]);
        }

        return $this->render('carte_bancaire/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/recap", name: "reservation.recap")]
    public function recapReservation($data): Response
    {
        return $this->render('reservation/recap.html.twig', [
            'controller_name' => 'ReservationController',
            'reservation_data' => $data // ??
        ]);
    }

    #[Route('/cancel/{id}', name: 'app_carte_bancaire.cancel', methods: ['POST'])]
    public function annulationReservation($id, ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->find($id);
        $reservationRepository->delete($reservation);

        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }
}
