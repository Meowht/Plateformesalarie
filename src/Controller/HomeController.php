<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Arrivee;
use App\Entity\Depart;
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(Request $request, Security $security, $imageFileName = null,): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException("Vous devez être connecté pour accéder à cette page.");
        }



        $arrivees = $this->entityManager->getRepository(Arrivee::class)->findAll();
        $Departs = $this->entityManager->getRepository(Depart::class)->findAll();
        $imageFileName = $request->query->get('imageFileName');

        // Rendre la vue avec les données récupérées
        return $this->render('slider/index.html.twig', [
            'arrivees' => $arrivees,
            'Departs' => $Departs,
            'imageFileName' => $imageFileName,
        ]);
    }
}
