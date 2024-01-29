<?php

namespace App\Controller;
use App\Entity\Arrivee;
use App\Form\ArriveeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ArriveeController extends AbstractController
{
    #[Route('/arrivee/ajouter', name: 'app_arrivee_ajouter')]   private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function addArrivee(Request $request): Response
    {
        $nouvelleArrivee = new Arrivee();
        $arriveeForm = $this->createForm(ArriveeType::class, $nouvelleArrivee);

        if ($request->isMethod('POST')) {
            $arriveeForm->handleRequest($request);

            if ($arriveeForm->isSubmitted() && $arriveeForm->isValid()) {
                // Enregistrez les données du formulaire en base de données
                $this->entityManager->persist($nouvelleArrivee);
                $this->entityManager->flush();

                // Redirigez vers la page d'accueil après avoir enregistré les données
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('arrivee/index.html.twig', [
            'form' => $arriveeForm->createView(),
        ]);
    }


    // PARTIE MODIFICATION DE L'ARRIVEE



    #[Route('/arrivee/{id}/modifier', name: 'app_arrivee_modifier')]
    public function modificationArrivee(Request $request, int $id) : Response
    {
    
        $arrivee = $this->entityManager->getRepository(Arrivee::class)->find($id);


        if (!$arrivee) {
            throw $this->createNotFoundException("L'arrivée avec l'ID $id n'a pas été trouvé.");
  
        }


        $form = $this->createForm(ArriveeType::class, $arrivee);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les modifications dans la base de données
            $this->entityManager->flush();
    
            // Redirigez vers la page principale ou une autre page appropriée
            return $this->redirectToRoute('app_home');
      
      
      
      
      
        }

 // Rendre la vue avec le formulaire
 return $this->render('arrivee/modification_Arrivee.html.twig', [
    'form' => $form->createView(),
    'arrivee' => $arrivee,
]);

    }

// PARTIE SUPPRESSION DE L'ARRIVEE

#[Route('/arrivee/{id}/supprimer', name: 'app_arrivee_supprimer', methods: ['POST', 'DELETE'])]
public function suppressionArrivee(Request $request, int $id): Response
{
    $arrivee = $this->entityManager->getRepository(Arrivee::class)->find($id);

    if (!$arrivee) {
        throw $this->createNotFoundException("L'arrivée avec l'ID $id n'a pas été trouvée.");
    }

    if ($request->isMethod('POST') || $request->isMethod('DELETE')) {
        // Supprimez l'élément de la base de données
        $this->entityManager->remove($arrivee);
        $this->entityManager->flush();

        // Redirigez vers la page principale ou une autre page appropriée
        return $this->redirectToRoute('app_home');
    }

    // Rendre la vue avec le formulaire de suppression (facultatif)
    return $this->render('arrivee/suppression_Arrivee.html.twig', [
        'arrivee' => $arrivee,
    ]);
}
}
