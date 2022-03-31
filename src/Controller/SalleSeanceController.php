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
    public function index($salle,$seance, \Symfony\Component\HttpFoundation\Request $request,SiegeRepository $siegeRepository): Response
    {

        $session = $request->getSession();
        $placeAcheter = $session->get('place', []);

        $siege = $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siege ,
            'salle' => $salle,
            'seance' => $seance,
            'siegesectedbyuser' => $placeAcheter,
            'break' => false
        ]);
    }

    #[Route('place/salle{salle}/seance{seance}/siege{numeroSiege}', name: 'selectPlace')]
    public function selectPlace($salle,$seance,$numeroSiege, \Symfony\Component\HttpFoundation\Request $request,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $session = $request->getSession();

        $placeAcheter = $session->get('place', []);

        $placeAcheter[$numeroSiege] = $numeroSiege;

        $session->set('place',$placeAcheter);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]),
            'salle' => $salle,
            'seance' => $seance,
            'siegesectedbyuser' => $placeAcheter
        ]);
    }

    #[Route('place/salle{salle}/seance{seance}/remove/siege{numeroSiege}', name: 'removeSelectPlace')]
    public function RemoveSelectPlace($salle,$seance,$numeroSiege, \Symfony\Component\HttpFoundation\Request $request,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $session = $request->getSession();

        $placeAcheter = $session->get('place', []);

        unset($placeAcheter[$numeroSiege]);

        $session->set('place',$placeAcheter);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]),
            'salle' => $salle,
            'seance' => $seance,
            'siegesectedbyuser' => $placeAcheter
        ]);
    }
}
