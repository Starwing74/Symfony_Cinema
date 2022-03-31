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
        $siegeEnCour = $siegeRepository->findBy(['status'=>"en cour",'salle'=>$salle,'seance'=>$seance]);

        $total = 0;

        $session = $request->getSession();

        $placeAcheter = $session->get('place', []);

        dd($placeAcheter);

        foreach ($siegeEnCour as $nbreDeSiege)
        {
            $total += 15;
        }

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
            'siege' => $siegeRepository->findBy(['status'=>"en cour",'salle'=>$salle,'seance'=>$seance]),
            'total' => $total,
            'connected' => $connected,
            'last_username' => $lastUserName,
            'error' => $errors,
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }
}
