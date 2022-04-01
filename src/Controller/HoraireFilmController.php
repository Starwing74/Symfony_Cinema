<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Repository\FilmRepository;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoraireFilmController extends AbstractController
{
    #[Route('/horaire/film/{id}', name: 'app_horaire_film')]
    public function index($id, SeanceRepository $seanceRepository, FilmRepository $filmRepository, Seance $seance): Response
    {
        return $this->render('horaire_film/index.html.twig', [
            'controller_name' => 'HoraireFilmController',
            'seance' => $seanceRepository->findBy(['film'=>$id]),
            'film' => $filmRepository->find($id)
        ]);
    }
}
