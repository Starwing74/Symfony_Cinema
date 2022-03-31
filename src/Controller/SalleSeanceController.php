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
        $placeSelect = $session->get('place', []);

        $siege = $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]);

        foreach ($siege as $siegetotal){
            if(!empty(array_filter($placeSelect, function
            ($place) use($siegetotal) {
                return $place===$siegetotal->getNumeroSiege();
            })))
            {
                $siegetotal->setStatus("en cour");
            }
        }

        return $this->render('salle_seance/index.html.twig', [
            'controller_name' => 'SalleSeanceController',
            'siege' => $siege ,
            'salle' => $salle,
            'seance' => $seance,
        ]);
    }

    #[Route('place/salle{salle}/seance{seance}/siege{numeroSiege}', name: 'selectPlace')]
    public function selectPlace($salle,$seance,$numeroSiege, \Symfony\Component\HttpFoundation\Request $request,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $session = $request->getSession();

        $placeSelect = $session->get('place', []);

        $placeSelect[$numeroSiege] = $numeroSiege;

        $siegetotal = $siegeRepository->findBy(['salle'=>$salle, 'seance'=>$seance]);

        $session->set('place',$placeSelect);

        return $this->redirectToRoute("app_salle_seance", ['salle'=> $salle, 'seance'=> $seance]);
    }

    #[Route('place/salle{salle}/seance{seance}/remove/siege{numeroSiege}', name: 'removeSelectPlace')]
    public function RemoveSelectPlace($salle,$seance,$numeroSiege, \Symfony\Component\HttpFoundation\Request $request,SiegeRepository $siegeRepository, Siege $siege): Response
    {
        $session = $request->getSession();

        $placeSelect = $session->get('place', []);

        unset($placeSelect[$numeroSiege]);

        $session->set('place',$placeSelect);

        return $this->redirectToRoute("app_salle_seance", ['salle'=> $salle, 'seance'=> $seance]);
    }
}
