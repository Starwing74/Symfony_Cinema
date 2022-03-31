<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SiegeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PayementController extends AbstractController
{
    #[Route('/payement/salle{salle}/seance{seance}', name: 'app_payement')]
    public function index($salle, $seance, \Symfony\Component\HttpFoundation\Request $request, AuthenticationUtils $authentificationUtils, SiegeRepository $siegeRepository): Response
    {

        $total = 0;

        $session = $request->getSession();

        $placeSelect = $session->get('place', []);

        foreach ($placeSelect as $nbreDeSiege)
        {
            $total += 15;
        }

        $reservationseance = $session->get('reservationSeance', []);

        $reservationseance = [
            'salle' => $salle,
            'seance' => $seance,
            'placesReservees' => $placeSelect,
            'prixTotal' => $total
        ];

        $session->set('reservationSeance',$reservationseance);

        $this->getUser();

        if($this->getUser()) {
            $connected = true;
        }
        else{
            $connected = false;
        }

        $errors = $authentificationUtils->getLastAuthenticationError();
        $lastUserName = $authentificationUtils->getLastUsername();

        if($errors) {
            $session = $request->getSession();

            $tentative = $session->get('tentative', []);

            $tentative = 5;

            $session->set('tentative',$tentative);
        }

        return $this->render('payement/index.html.twig', [
            'controller_name' => 'PayementController',
            'siege' => $placeSelect,
            'total' => $total,
            'connected' => $connected,
            'last_username' => $lastUserName,
            'error' => $errors,
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }
}
