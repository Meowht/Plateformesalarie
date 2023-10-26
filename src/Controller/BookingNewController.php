<?php

namespace App\Controller;

use App\Entity\Booking;

use App\Form\NewBookingType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingNewController extends AbstractController
{
  
    #[Route('/bookingnew', name: 'new_booking')]
     public function newBooking(Request $request, ManagerRegistry $entityManager): Response
    {
        // Créez une nouvelle instance de l'entité Booking
        $newBooking = new Booking();
   dd($newBooking);
        // Créez le formulaire en utilisant le formulaire NewBookingType et l'entité Booking
        $form = $this->createForm(NewBookingType::class, $newBooking);
       
        // Gérez la soumission du formulaire
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire a été soumis et est valide
            
            // Vous pouvez maintenant enregistrer la nouvelle réservation en base de données
            $this->entityManager->persist($newBooking);
            $this->entityManager->flush();
    
            // Mise à jour du calendrier : obtenir les réservations pour la date souhaitée
            $desiredDate = $newBooking->getBeginAt(); // Supposons que la date souhaitée est la date de début de la réservation
    
            $calendarData = $this->entityManager->getRepository(Booking::class)->findBy(['BeginAt'=> $desiredDate]);
    
            // Puis, vous pouvez rediriger vers une vue qui affiche à la fois le calendrier mis à jour et un message de confirmation
            return $this->render('booking_new/confirmation.html.twig', [
                'form' => $form->createView(),
                'calendar' => $calendarData,
                'confirmationMessage' => 'Votre réservation a été ajoutée avec succès.'
            ]);
        }
    
        // Affichez le formulaire dans le modèle Twig dédié à la création de nouvelles réservations
        return $this->render('booking_new/index.html.twig', [
            'form' => $form->createView(),
           
            
        ]);
    }
    
}
