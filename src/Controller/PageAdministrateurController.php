<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Film;
use App\Form\FilmSearchDTO;
use App\Form\FilmSearchFormType;
use App\Form\RajouterFilmDTO;
use App\Form\RajouterFilmFormType;
use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageAdministrateurController extends AbstractController
{
    #[Route('/page/administrateur', name: 'app_page_administrateur')]
    public function index(CategoryRepository $categoryRepository, FilmRepository $filmRepository, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $dto = new RajouterFilmDTO();

        $form = $this->createForm(
            RajouterFilmFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categoriefilm = $categoryRepository->findOneBy(['type'=>$dto->Categorie]);


            /** @internal Category $categorieid */
            $categorieid = $categoriefilm->getId();

            $film = new Film();
            $film->setName($dto->Name);
            $film->setImage($dto->Image);
            $film->setResumer($dto->Resumer);
            $film->setDurer($dto->Durer);
            $film->setDirecteur($dto->Directeur);
            $film->setBandeAnnonce($dto->BandeAnnonce);
            $film->setCategory($categoryRepository->find($categorieid));
            $filmRepository->save($film);

            return $this->redirectToRoute("app_page_administrateur");
        }

        return $this->render('page_administrateur/index.html.twig', [
            'controller_name' => 'PageAdministrateurController',
            'Role' => $this->getUser()->getRoles()[0],
            'film' => $filmRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/page/administrateur/edit/{id}', name: 'page_administrateur_edit')]
    public function edit($id,CategoryRepository $categoryRepository, FilmRepository $filmRepository, \Symfony\Component\HttpFoundation\Request $request, Film $film): Response
    {
        $getfilm = $filmRepository->findOneBy(['id'=>$id]);
        $categorie = $categoryRepository->findOneBy(['id'=>$getfilm->getCategory()]);

        $dto = new RajouterFilmDTO();

        $dto->Name = $getfilm->getName();
        $dto->Image = $getfilm->getImage();
        $dto->Resumer = $getfilm->getResumer();
        $dto->Durer = $getfilm->getDurer();
        $dto->Directeur = $getfilm->getDirecteur();
        $dto->BandeAnnonce = $getfilm->getBandeAnnonce();
        $dto->Categorie = $categorie->getType();

        $form = $this->createForm(
            RajouterFilmFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categoriefilm = $categoryRepository->findOneBy(['type'=>$dto->Categorie]);

            /** @internal Category $categorieid */
            $categorieid = $categoriefilm->getId();

            $film->setName($dto->Name);
            $film->setImage($dto->Image);
            $film->setResumer($dto->Resumer);
            $film->setDurer($dto->Durer);
            $film->setDirecteur($dto->Directeur);
            $film->setBandeAnnonce($dto->BandeAnnonce);
            $film->setCategory($categoryRepository->find($categorieid));
            $filmRepository->save($film);

            return $this->redirectToRoute("app_page_administrateur");
        }

        return $this->render('page_administrateur/edit.html.twig', [
            'controller_name' => 'PageAdministrateurController',
            'Role' => $this->getUser()->getRoles()[0],
            'film' => $filmRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/page/administrateur/delete/{id}', name: 'page_administrateur_delete')]
    public function delete($id,CategoryRepository $categoryRepository, FilmRepository $filmRepository, \Symfony\Component\HttpFoundation\Request $request, Film $film): Response
    {
        $filmRepository->delete($film);

        return $this->redirectToRoute("app_page_administrateur");
    }


}
