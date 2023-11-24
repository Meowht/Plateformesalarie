<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\MenuDuJour;
use App\Form\MenuDuJourType;
class SliderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/slider', name: 'app_slider')]
    public function index(Request $request, Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException("Vous devez être connecté pour accéder à cette page.");
        }

        // Récupérez les données depuis la base de données
        $menuRepository = $this->entityManager->getRepository(MenuDuJour::class);
        $menus = $menuRepository->findAll();

        // Rendre la vue avec les données récupérées
        return $this->render('slider/index.html.twig', [
            'menus' => $menus,
        ]);
    }


// MODIFICATION MENU 

#[Route('/menu/{id}/modifier-midi', name: 'app_menu_modifier_midi')]
#[Route('/menu/{id}/modifier-soir', name: 'app_menu_modifier_soir')]
public function modifierMenuMidiEtSoir(Request $request, int $id): Response
{
    $menu = $this->entityManager->getRepository(MenuDuJour::class)->find($id);

    if (!$menu) {
        throw $this->createNotFoundException("Le menu avec l'ID $id n'a pas été trouvé.");
    }

    // Créez un formulaire de modification et pré-remplissez-le avec les données du menu
    $form = $this->createForm(MenuDuJourType::class, $menu);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Enregistrez les modifications dans la base de données
        $this->entityManager->flush();

        // Redirigez vers la page principale ou une autre page appropriée
        return $this->redirectToRoute('app_slider');
    }

    // Rendre la vue avec le formulaire
    return $this->render('menu_du_jour/modification_Menu.html.twig', [
        'form' => $form->createView(),
        'menu' => $menu,
    ]);
}


// SUPPRESSION MENU 
#[Route('/menu/{id}/supprimer', name: 'app_menu_supprimer')]
public function supprimerMenu(Request $request, int $id): Response
{
    $menu = $this->entityManager->getRepository(MenuDuJour::class)->find($id);

    if (!$menu) {
        throw $this->createNotFoundException("Le menu avec l'ID $id n'a pas été trouvé.");
    }

    // Gérez la demande de suppression
    if ($request->isMethod('POST') || $request->isMethod('DELETE')) {
        // Supprimez l'élément de la base de données
        $this->entityManager->remove($menu);
        $this->entityManager->flush();

        // Redirigez vers la page principale ou une autre page appropriée
        return $this->redirectToRoute('app_slider');
    }

    // Rendre la vue avec le formulaire de suppression (facultatif)
    return $this->render('menu_du_jour/suppression_Menu.html.twig', [
        'menu' => $menu,
    ]);
}



}
