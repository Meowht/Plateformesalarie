<?php

namespace App\Controller;

use App\Entity\Depart;
use App\Form\DepartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class DepartController extends AbstractController
{
    #[Route('/depart', name: 'app_depart-ajouter')]

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function addDepart(Request $request): Response
    {
        $nouvelleDepart = new Depart();
        $DepartForm = $this->createForm(DepartType::class, $nouvelleDepart);

        if ($request->isMethod('POST')) {
            $DepartForm->handleRequest($request);

            if ($DepartForm->isSubmitted() && $DepartForm->isValid()) {
                // Enregistrez les données du formulaire en base de données
                $this->entityManager->persist($nouvelleDepart);
                $this->entityManager->flush();

                // Redirigez vers la page d'accueil après avoir enregistré les données
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('Depart/index.html.twig', [
            'form' => $DepartForm->createView(),
        ]);
    }


    // PARTIE MODIFICATION DE L'Depart



    #[Route('/Depart/{id}/modifier', name: 'app_depart_modifier')]
    public function modificationDepart(Request $request, int $id) : Response
    {
    
        $Depart = $this->entityManager->getRepository(Depart::class)->find($id);


        if (!$Depart) {
            throw $this->createNotFoundException("L'arrivée avec l'ID $id n'a pas été trouvé.");
  
        }


        $form = $this->createForm(DepartType::class, $Depart);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les modifications dans la base de données
            $this->entityManager->flush();
    
            // Redirigez vers la page principale ou une autre page appropriée
            return $this->redirectToRoute('app_home');
      
      
      
      
      
        }

 // Rendre la vue avec le formulaire
 return $this->render('Depart/modification_Depart.html.twig', [
    'form' => $form->createView(),
    'Depart' => $Depart,
]);

    }

// PARTIE SUPPRESSION DE Depart

#[Route('/Depart/{id}/supprimer', name: 'app_Depart_supprimer', methods: ['POST', 'DELETE'])]
public function suppressionDepart(Request $request, int $id): Response
{
    $Depart = $this->entityManager->getRepository(Depart::class)->find($id);

    if (!$Depart) {
        throw $this->createNotFoundException("L'arrivée avec l'ID $id n'a pas été trouvée.");
    }

    if ($this->isCsrfTokenValid('delete' . $Depart->getId(), $request->request->get('_token'))
        && ($request->isMethod('POST') || $request->isMethod('DELETE'))
    ) {
        // Remove the item from the database
        $this->entityManager->remove($Depart);
        $this->entityManager->flush();

        // Redirect to the main page or another appropriate page
        return $this->redirectToRoute('app_home');
    }

    // Render the view with the delete form (if needed)
    return $this->render('Depart/suppression_Depart.html.twig', [
        'Depart' => $Depart,
    ]);
}


}
