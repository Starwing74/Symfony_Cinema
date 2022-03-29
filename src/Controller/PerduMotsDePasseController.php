<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CodeDTO;
use App\Form\CodeFormType;
use App\Form\NouveauMotsDePasseDTO;
use App\Form\NouveauMotsDePasseFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PerduMotsDePasseFormType;
use App\Form\PerduMotsDePasseDTO;
use App\Repository\UserRepository;

class PerduMotsDePasseController extends AbstractController
{
    #[Route('/perdu/mots/de/passe', name: 'app_perdu_mots_de_passe')]
    public function index(\Symfony\Component\HttpFoundation\Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $session = $request->getSession();

        $code_tempo = $session->get('codeTempo', []);

        $dto = new PerduMotsDePasseDTO();

        $form = $this->createForm(
            PerduMotsDePasseFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($userRepository->findBy(['mail'=>$dto->Mail])){

                $random = random_int(100000,999999);

                $email = (new Email())
                    ->from('cinemagrenoble@gmail.com')
                    ->to($dto->Mail)
                    ->subject('Code temporaire pour votre compte Cinema Grenoble')
                    ->text('Voici votre code temporaire ' . $random . ' pour changer le mots de passe veuillez l entrer pour changer votre mots de passe');

                $mailer->send($email);
                $session->set('codeTempo',$random);
                $tempo_mail = "(" . $dto->Mail . ")";
                $result = $userRepository->identifyByEmail($dto->Mail);

                return $this->redirectToRoute("codePassword", ['id'=> $result->getId()]);
            }
        }

        return $this->render('perdu_mots_de_passe/index.html.twig', [
            'controller_name' => 'PerduMotsDePasseController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/perdu/mots/de/passe/code/{id}', name: 'codePassword')]
    public function codePassword($id,\Symfony\Component\HttpFoundation\Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $session = $request->getSession();
        $code_tempo = $session->get('codeTempo', []);

        $dto = new CodeDTO();

        $form = $this->createForm(
            CodeFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $code_tempo = $session->get('codeTempo', []);
            if($code_tempo == $dto->Code){
                return $this->redirectToRoute("newPassword", ['id'=> $id]);
            }
        }

        return $this->render('perdu_mots_de_passe/index.html.twig', [
            'controller_name' => 'PerduMotsDePasseController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/perdu/mots/de/passe/newpassword/{id}', name: 'newPassword')]
    public function newPassword(UserPasswordHasherInterface $userPasswordHasher,$id,\Symfony\Component\HttpFoundation\Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $session = $request->getSession();
        $code_tempo = $session->get('codeTempo', []);
        $user = $userRepository->identifyById($id);
        $dto = new NouveauMotsDePasseDTO();
        $form = $this->createForm(
            NouveauMotsDePasseFormType::class,
            $dto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($userPasswordHasher->hashPassword($user, $dto->NewPassword));
            $userRepository->save($user);

            $email = (new Email())
                ->from('cinemagrenoble@gmail.com')
                ->to($user->getMail())
                ->subject('Changement de mots de passe')
                ->text('Nous avons changer votre mots de pass pour le compte ' . $user->getMail() . ' votre nouveaux mots de passe est ' . $user->getPassword());

            $mailer->send($email);

            $code_tempo = null;
            $session->set('codeTempo',$code_tempo);

            return $this->redirectToRoute("login");
        }

        return $this->render('perdu_mots_de_passe/index.html.twig', [
            'controller_name' => 'PerduMotsDePasseController',
            'form' => $form->createView(),
        ]);
    }
}
