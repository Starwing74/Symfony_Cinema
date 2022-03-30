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

        $sessionSiege = $session->get('place', []);

        $sessionSiege = $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]);

        $session->set('place',$sessionSiege);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $sessionSiege ,
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }

    #[Route('place/salle{salle}/seance{seance}/siege{numeroSiege}', name: 'selectPlace')]
    public function selectPlace($salle,$seance,$numeroSiege, \Symfony\Component\HttpFoundation\Request $request,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $siege->setStatus("en cour");
        $siegeRepository->save($siege);

        $session = $request->getSession();

        $session->clear();
        $placeAcheter = $session->get('siege', []);

        $session->set('siege',$placeAcheter);

        dd($placeAcheter);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]),
            'salle' => $salle,
            'seance' => $seance,
            'placeencour' => $placeAcheter
        ]);
    }

    #[Route('place/salle{salle}/seance{seance}/remove/siege{numeroSiege}', name: 'removeSelectPlace')]
    public function RemoveSelectPlace($salle,$seance,$numeroSiege, \Symfony\Component\HttpFoundation\Request $request,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $siege->setStatus("libre");
        $siegeRepository->save($siege);

        $session = $request->getSession();

        $placeAcheter = $session->get('placeacheter', []);
        $i = 0;
        foreach ($placeAcheter as $placeAcheter)
        {
            if($placeAcheter == $numeroSiege)
            {
                unset($placeAcheter[$i]);
            }
            $i++;
        }

        $session->set('placeacheter',$placeAcheter);

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]),
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }
}
