<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\EditBookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// EDITION DE L'EVENT ///////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
class BookingEditController extends AbstractController
{
    #[Route('/booking/edit/{id}', name: 'app_booking_edit')]
    public function edit(Booking $booking, Request $request, EntityManagerInterface $entityManager): Response
    {
        $editBookingForm = $this->createForm(EditBookingType::class, $booking);

        $editBookingForm->handleRequest($request);

        if ($editBookingForm->isSubmitted() && $editBookingForm->isValid()) {
            // Mettez à jour la réservation en base de données
            $entityManager->flush();

            // Redirigez l'utilisateur vers une page de confirmation ou ailleurs
            return $this->redirectToRoute('app_booking_show', ['id' => $booking->getId()]);
        }

        return $this->render('booking_edit/index.html.twig', [
            'editBookingForm' => $editBookingForm->createView(),
            'booking' => $booking, // Vous pouvez transmettre d'autres données nécessaires à la vue
        ]);
    }

////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SUPPRESSION DE L'EVENT ///////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

#[Route('/booking/delete/{id}', name: 'app_booking_delete')]
public function delete(Booking $booking, EntityManagerInterface $entityManager): Response
{ 
    // Supprimez la réservation
    $id = $booking->getId();
    $entityManager->remove($booking);
    $entityManager->flush();

    // Redirigez l'utilisateur vers la page de confirmation ou ailleurs
    return $this->redirectToRoute('app_booking');
}

}

