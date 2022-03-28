<?php

namespace App\Controller;

use App\Repository\SiegeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
    #[Route('/payement', name: 'app_payement')]
    public function index(SiegeRepository $siegeRepository): Response
    {
        $siegeEnCour = $siegeRepository->findBy(['status'=>"en cour"]);

        $total = 0;

        foreach ($siegeEnCour as $nbreDeSiege)
        {
            $total += 15;
        }

        return $this->render('payement/index.html.twig', [
            'controller_name' => 'PayementController',
            'siege' => $siegeRepository->findBy(['status'=>"en cour"]),
            'total' => $total
        ]);
    }
}
