<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Review;
use App\Form\FilmSearchDTO;
use App\Form\FilmSearchFormType;
use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(\Symfony\Component\HttpFoundation\Request $request, ReviewRepository $reviewRepository, CategoryRepository $categoryRepository, FilmRepository $filmRepository): Response
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

        if($this->getUser())
        {
            $role = $this->getUser()->getRoles()[0];
        }
        else{
            $role = null;
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Category' => $categoryRepository->findAll(),
            'Films' => $filmRepository->findAll(),
            'form' => $form->createView(),
            'reviewlist' => $reviewRepository->findAll(),
            'Role' => $role,
        ]);
    }

    #[Route('/accueil/SearchFilm/{search}', name: 'SearchFilm')]
    public function indexSearchFilm($search, \Symfony\Component\HttpFoundation\Request $request, ReviewRepository $reviewRepository, CategoryRepository $categoryRepository, FilmRepository $filmRepository): Response
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

        if($this->getUser())
        {
            $role = $this->getUser()->getRoles()[0];
        }
        else{
            $role = null;
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Category' => $categoryRepository->findAll(),
            'Films' => $filmRepository->findBy(['name'=>$search]),
            'form' => $form->createView(),
            'reviewlist' => $reviewRepository->findAll(),
            'Role' => $role,
        ]);
    }

    #[Route('/accueil/category/{id}', name: 'category')]
    public function indexPickCategory($id, \Symfony\Component\HttpFoundation\Request $request, ReviewRepository $reviewRepository, Category $category, CategoryRepository $categoryRepository, FilmRepository $filmRepository): Response
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

        if($this->getUser())
        {
            $role = $this->getUser()->getRoles()[0];
        }
        else{
            $role = null;
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Category' => $categoryRepository->findAll(),
            'Films' => $filmRepository->findBy(['category'=>$category->getId()]),
            'form' => $form->createView(),
            'reviewlist' => $reviewRepository->findAll(),
            'Role' => $role,
        ]);
    }

    #[Route('/accueil/like/film{idfilm}/user{iduser}', name: 'likefilm')]
    public function likefilm($idfilm, $iduser, ReviewRepository $reviewRepository, FilmRepository $filmRepository, UserRepository $userRepository): Response
    {
        if(!$reviewRepository->findOneBy(['film'=>$idfilm, 'user'=>$iduser]))
        {
            $user = $userRepository->findOneBy(['id'=>$iduser]);
            $film = $filmRepository->findOneBy(['id'=>$idfilm]);

            $review = new Review();
            $review->setAime("true");
            $review->setUser($user);
            $review->setFilm($film);
            $reviewRepository->save($review);
        }
        else{
            $review = $reviewRepository->findOneBy(['user'=>$iduser,'film'=>$idfilm]);

            $reviewRepository->delete($review);
        }

        return $this->redirectToRoute("app_accueil");
    }
}
