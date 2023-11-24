<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\MenuDuJour;
use App\Form\MenuDuJourType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; // Ajout de l'import

class MenuDuJourController extends AbstractController
{
    private $entityManager; // Déclaration de la propriété

    // Injection de dépendance pour l'EntityManager
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/menuSucces/{menuId}', name: 'app_menu_success')]
    public function menuSucces(): Response
    {
        // Vous pouvez personnaliser cette action si nécessaire
        return $this->render('menu_du_jour/MenuSuccess.html.twig');
    }

    #[Route('/menu_du_jour', name: 'app_menu_du_jour')]
public function new(Request $request): Response
{
    $newMenu = new MenuDuJour();
    $newMenuForm = $this->createForm(MenuDuJourType::class, $newMenu);

    if ($request->isMethod('POST')) {
        $newMenuForm->handleRequest($request);

        if ($newMenuForm->isSubmitted() && $newMenuForm->isValid()) {
            // Enregistrez les données du formulaire en base de données
            $entityManager = $this->entityManager;
            $entityManager->persist($newMenu);
            $entityManager->flush();
        
            // Redirigez vers la page d'accueil après avoir enregistré les données
            return $this->redirectToRoute('app_home');
        }
    }

    return $this->render('menu_du_jour/index.html.twig', [
        'newMenuForm' => $newMenuForm->createView(),
    ]);
}
}
