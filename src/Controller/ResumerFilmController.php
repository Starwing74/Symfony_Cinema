<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Film;
use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResumerFilmController extends AbstractController
{
    #[Route('/resumer/film', name: 'app_resumer_film')]
    public function index(): Response
    {
        return $this->render('resumer_film/index.html.twig', [
            'controller_name' => 'ResumerFilmController',
        ]);
    }

    #[Route('/accueil/resumer/{id}', name: 'ResumerFilm')]
    public function indexResumerFilm(FilmRepository $filmRepository, Film $film): Response
    {
        return $this->render('resumer_film/index.html.twig', [
            'controller_name' => 'ResumerFilmController',
            'FilmResumer' => $filmRepository->findBy(['id'=>$film->getId()])
        ]);
    }
}
