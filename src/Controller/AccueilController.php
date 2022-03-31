<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\FilmSearchDTO;
use App\Form\FilmSearchFormType;
use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(\Symfony\Component\HttpFoundation\Request $request, CategoryRepository $categoryRepository, FilmRepository $filmRepository): Response
    {
        $dto = new FilmSearchDTO();

        $form = $this->createForm(
            FilmSearchFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute("SearchFilm" , ['search'=> $dto->FilmSearch]);
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Category' => $categoryRepository->findAll(),
            'Films' => $filmRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/accueil/SearchFilm/{search}', name: 'SearchFilm')]
    public function indexSearchFilm($search, \Symfony\Component\HttpFoundation\Request $request, CategoryRepository $categoryRepository, FilmRepository $filmRepository): Response
    {
        $dto = new FilmSearchDTO();

        $form = $this->createForm(
            FilmSearchFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute("SearchFilm" , ['search'=> $dto->FilmSearch]);
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Category' => $categoryRepository->findAll(),
            'Films' => $filmRepository->findBy(['name'=>$search]),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/accueil/category/{id}', name: 'category')]
    public function indexPickCategory($id, \Symfony\Component\HttpFoundation\Request $request, Category $category, CategoryRepository $categoryRepository, FilmRepository $filmRepository): Response
    {
        $dto = new FilmSearchDTO();

        $form = $this->createForm(
            FilmSearchFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute("SearchFilm" , ['search'=> $dto->FilmSearch]);
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Category' => $categoryRepository->findAll(),
            'Films' => $filmRepository->findBy(['category'=>$category->getId()]),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/accueil/like/film{idfilm}/user{iduser}', name: 'likefilm')]
    public function likefilm($idfilm, $iduser): Response
    {
        dd($idfilm . " " . $iduser);
    }
}
