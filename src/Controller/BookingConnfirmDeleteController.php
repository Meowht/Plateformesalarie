<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingConnfirmDeleteController extends AbstractController
{
    
    #[Route('/booking/confirm/delete', name: 'app_booking_confirm_delete')]
public function confirmDelete(Booking $booking): Response
{
    return $this->render('booking_confirm_delete/index.html.twig', [
        'booking' => $booking,
        
    ]);
}

#[Route('/booking/confirm/deletee/{id}', name: 'app_booking_confirm_deletee')]
public function confirmDelee($id): Response
{

   
    return $this->render('bookingconnfirmdelete/index.html.twig', [
        'id' => $id
    ]);
}
}
