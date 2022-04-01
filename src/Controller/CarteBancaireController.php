<?php

namespace App\Controller;

use App\DTO\CBDto;
use App\Entity\User;
use App\Form\CBType;
use App\Repository\CarteBancaireRepository;
use App\Services\CBService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/carte_bancaire")]
class CarteBancaireController extends AbstractController
{
    private CBService $cbService;

    public function __construct(CBService $cbService) {
        $this->cbService = $cbService;
    }

    #[Route('/', name: 'app_carte_bancaire')]
    public function index(CarteBancaireRepository $carteBancaireRepository): Response
    {
        $user = $this->getUser();
        $cartes = $user->getCarteBancaires($carteBancaireRepository);
        return $this->render('carte_bancaire/index.html.twig', [
            'controller_name' => 'CarteBancaireController',
            'cartes' => $cartes
        ]);
    }

    #[Route("/add", name: "app_carte_bancaire.add", methods: ["GET", "POST"])]
    public function ajouterCarteBancaire(Request $request): Response
    {
        $cbDto = new CBDto();

        $form = $this->createForm(CBType::class, $cbDto);
        $form->handleRequest($request);

        $now = new DateTime();

        if ($form->isSubmitted() && $form->isValid() && $form->getData()->date_expiration > $now) {
            /** @var User $user */
            $user = $this->getUser();
            $this->cbService->enterNewCarteBancaire($cbDto, $user);

            $this->addFlash('success', 'Carte Bancaire ajoutée!');

            return $this->redirectToRoute('app_carte_bancaire', [
                'user' => $this->getUser()
            ]);
        } else {
            $this->addFlash('error', 'Les informations entrées sont erronées ou la carte n\'est plus valide');
        }

        return $this->render('carte_bancaire/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_carte_bancaire.delete', methods: ['POST'])]
    public function destroy($id, CarteBancaireRepository $carteBancaireRepository): Response
    {
        $cb = $carteBancaireRepository->find($id);
        $carteBancaireRepository->delete($cb);

        return $this->redirectToRoute('app_carte_bancaire', [], Response::HTTP_SEE_OTHER);
    }
}
