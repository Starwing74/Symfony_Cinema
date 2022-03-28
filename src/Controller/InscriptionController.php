<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\InscriptionFormType;
use App\Form\InscriptionDTO;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(\Symfony\Component\HttpFoundation\Request $request, MailerInterface $mailer, UserRepository $userRepository): Response
    {
        $dto = new InscriptionDTO();

        $form = $this->createForm(
            InscriptionFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($dto->Civilite == 1) {
                $Civilite = 'Madame';
            }
            if ($dto->Civilite == 2){
                $Civilite = 'Monsieur';
            }

            if($userRepository->findBy(['mail'=>$dto->Mail])){
                $this->addFlash('error', 'Ce mail existe déjà, séléctionner un autre mail ou connecter vous au compte');
                return $this->redirectToRoute("app_inscription");
            }
            else{
                $email = (new Email())
                    ->from('cinemagrenoble@gmail.com')
                    ->to($dto->Mail)
                    ->subject('Creation de votre compte')
                    ->text(
                        'Merci' . $Civilite . " " . $dto->Nom . 'pour avoir créer notre compte!' . '
                          Vaut information ce sont enregistrer de n otre base de donnée' . '
                          AdresseMail: ' . $dto->Mail . '
                          Password: ' . $dto->Password);

                $mailer->send($email);

                $user = new User();
                $user->setName($dto->Prenom);
                $user->setLastName($dto->Nom);
                $user->setPassword($dto->Password);
                $user->setMail($dto->Mail);
                $user->setRole("client");
                $user->setLastLogin(new \DateTime());
                $userRepository->save($user);

                return $this->redirectToRoute("login");
            }
        }

        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'form' => $form->createView(),
        ]);
    }
}
