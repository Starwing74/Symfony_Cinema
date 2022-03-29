<?php

namespace App\Controller;

use App\Entity\Siege;
use App\Repository\SiegeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleSeanceController extends AbstractController
{
    #[Route('place/salle{salle}/seance{seance}', name: 'app_salle_seance')]
    public function index($salle,$seance,SiegeRepository $siegeRepository): Response
    {
        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]),
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }

    #[Route('place/salle{salle}/seance{seance}/siege{numeroSiege}', name: 'selectPlace')]
    public function selectPlace($salle,$seance,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $siege->setStatus("en cour");
        $siegeRepository->save($siege);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]),
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }

    #[Route('place/salle{salle}/seance{seance}/remove/siege{numeroSiege}', name: 'removeSelectPlace')]
    public function RemoveSelectPlace($salle,$seance,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $siege->setStatus("libre");
        $siegeRepository->save($siege);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]),
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }
}
