<?php

namespace App\Controller;

use App\DTO\ReservationDto;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\SalleRepository;
use App\Repository\SeanceRepository;
use App\Repository\SiegeRepository;
use App\Repository\UserRepository;
use App\Services\ReservationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
    public function completerReservation(Request $request, SiegeRepository $siegeRepository, SalleRepository $salleRepository, SeanceRepository $seanceRepository, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $reservationDto = new ReservationDto();

        $form = $this->createForm(ReservationType::class, $reservationDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
            $data = $session->get('reservationSeance', []);
            $reservation = $this->reservationService->createNewReservation($reservationDto, $data);

            foreach ($data['placesReservees'] as $siegeName){
                $siege = $siegeRepository->findOneBy([
                    'numeroSiege' => $siegeName,
                    'salle' => $salleRepository->find($data['salle']),
                    'seance' => $seanceRepository->find($data['seance'])
                ]);
                $reservation->addSiege($siege);
                $siege->setStatus('pris');
                $user_id = $this->getUser()->getId();
                $user = $userRepository->find($user_id);
                $siege->setUser($user);
                $siegeRepository->save($siege);
            }

            $email = (new Email())
                ->from('cinemagrenoble@gmail.com')
                ->to($this->getUser()->getMail())
                ->subject('Confirmation de réservation')
                ->text('Test');

            $session->clear();

            $mailer->send($email);

            $this->addFlash('success', 'Reservation faite!');

            return $this->redirectToRoute('app_accueil', [
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
