<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConnectionController extends AbstractController
{
    #[Route('/connection', name: 'login')]
    public function index(): Response
    {
        return $this->render('connection/index.html.twig', [
            'controller_name' => 'ConnectionController',
        ]);
    }
}
