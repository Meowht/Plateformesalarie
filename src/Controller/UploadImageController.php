<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Form\UploadImageType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageController extends AbstractController
{
    #[Route('/upload/image', name: 'app_upload_image')]
    public function uploadImage(Request $request)
    {
        // Créer une instance du formulaire UploadImageType
        $formulaire = $this->createForm(UploadImageType::class);

        // Gérer la soumission du formulaire et la validation des données
        $formulaire->handleRequest($request);

        // Variable pour stocker le nom du fichier téléchargé
        $imageFileName = null;

        // Vérifier si le formulaire a été soumis et si les données sont valides
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // Récupérer le fichier téléchargé à partir du champ 'UploadedImage' du formulaire
            $imageFile = $formulaire->get('UploadedImage')->getData();

            // Vérifier si un fichier a été sélectionné
            if ($imageFile) {
                // Générer un nouveau nom de fichier unique
                $newFilename = "image" . uniqid() . "." . $imageFile->guessExtension();

                try {
                    // Déplacer le fichier téléchargé vers le dossier 'public/DownloadedImage'
                    $imageFile->move($this->getParameter('kernel.project_dir') . '/public/DownloadedImage', $newFilename);

                    // Mettre à jour la variable avec le nom du fichier pour affichage dans la vue
                    $imageFileName = $newFilename;

                    // Rediriger vers la page du slider avec le nom du fichier comme paramètre
                    return $this->redirectToRoute('app_slider', ['imageFileName' => $imageFileName]);
                } catch (FileException $e) {
                    // Gestion des erreurs en cas d'échec du téléchargement du fichier
                    $this->addFlash('error', 'Une erreur s\'est produite lors du téléchargement de l\'image.');
                }
            } else {
                // Le formulaire est soumis, mais aucun fichier n'a été sélectionné
                $this->addFlash('error', 'Aucun fichier image n\'a été sélectionné.');
            }
        } elseif ($request->getMethod() === 'POST' && !$formulaire->isValid()) {
            // Le formulaire a été soumis, mais n'est pas valide
            $this->addFlash('error', 'Le formulaire contient des erreurs.');
        }

        // Rendre la réponse avec la vue même si le téléchargement a échoué
        return $this->render('upload_image/index.html.twig', [
            'formulaire' => $formulaire->createView(), // Créer une représentation visuelle du formulaire
            'imageFileName' => $imageFileName, // Passer le nom du fichier pour l'affichage dans la vue
        ]);
    }
}