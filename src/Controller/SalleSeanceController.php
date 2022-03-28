<?php

namespace App\Controller;

use App\Entity\Siege;
use App\Repository\SiegeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleSeanceController extends AbstractController
{
    #[Route('/salle/seance', name: 'app_salle_seance')]
    public function index(SiegeRepository $siegeRepository): Response
    {

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findAll(),
        ]);
    }

    #[Route('/salle/seance/{numeroSiege}', name: 'selectPlace')]
    public function selectPlace(SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $siege->setStatus("en cour");
        $siegeRepository->save($siege);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findAll()
        ]);
    }

    #[Route('/salle/seance/remove/{numeroSiege}', name: 'removeSelectPlace')]
    public function RemoveSelectPlace(SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $siege->setStatus("libre");
        $siegeRepository->save($siege);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findAll()
        ]);
    }
}
