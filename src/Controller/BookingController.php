<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException("Vous devez être connecté pour accéder à cette page.");
        }


        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/booking/show/{id}', name: 'app_booking_show')]
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function show($id): Response
    {
        $booking = $this->entityManager->getRepository(Booking::class)->find($id);

        if (!$booking) {
            throw $this->createNotFoundException('Réservation non trouvée pour l\'ID : ' . $id);
        }

        return $this->render('booking/index.html.twig', ['booking' => $booking]);
    }
}
