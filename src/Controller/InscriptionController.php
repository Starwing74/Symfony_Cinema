<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\InscriptionFormType;
use App\Form\InscriptionDTO;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $dto = new InscriptionDTO();

        $form = $this->createForm(
            InscriptionFormType::class,
            $dto
        );
        $form->handleRequest($request);

        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'form' => $form->createView(),
        ]);
    }
}
