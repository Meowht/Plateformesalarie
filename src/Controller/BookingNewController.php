<?php

namespace App\Controller;

use App\Entity\Booking;

use App\Form\NewBookingType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class BookingNewController extends AbstractController
{
    #[Route('/new-confirmation', name: 'new_confirmation_page')]
    public function confirmationPage(): Response
    {
        return $this->render('booking_new/new_confirmation_page.html.twig');
    }
    #[Route('/booking_new', name: 'app_booking_new')]
    #[IsGranted("ROLE_USER", "ROLE_ADMIN")]
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function new(Request $request, EventDispatcherInterface $eventDispatcher, Security $security): Response
    {
        $user = $security->getUser();

    if (!$user) {
        throw $this->createAccessDeniedException("Vous devez être connecté pour accéder à cette page.");
    }
        
        // dd($user);
        $newBooking = new Booking();
        $newBookingForm = $this->createForm(NewBookingType::class, $newBooking);

        if ($request->isMethod('POST')) {
            $newBookingForm->handleRequest($request);

            if ($newBookingForm->isSubmitted() && $newBookingForm->isValid()) {
                // Enregistrez le nouveau booking en base de données

                $entityManager = $this->entityManager;
                $entityManager->persist($newBooking);
                $entityManager->flush();

                return $this->redirectToRoute('new_confirmation_page'); 
            }
        }

        return $this->render('booking_new/index.html.twig', [
            'newBookingForm' => $newBookingForm->createView(),
        ]);
    }
















    //  public function newBooking(Request $request, ManagerRegistry $entityManager): Response

    //     {
//         // Créez une nouvelle instance de l'entité Booking
//         $newBooking = new Booking();

    //    dd($newBooking);
//         // Créez le formulaire en utilisant le formulaire NewBookingType et l'entité Booking
//         $form = $this->createForm(NewBookingType::class, $newBooking);

    //         // Gérez la soumission du formulaire
//         $form->handleRequest($request);

    //         if ($form->isSubmitted() && $form->isValid()) {
//             // Le formulaire a été soumis et est valide

    //             // Vous pouvez maintenant enregistrer la nouvelle réservation en base de données
//             $this->entityManager->persist($newBooking);
//             $this->entityManager->flush();

    //             // Mise à jour du calendrier : obtenir les réservations pour la date souhaitée
//             $desiredDate = $newBooking->getBeginAt(); // Supposons que la date souhaitée est la date de début de la réservation

    //             $calendarData = $this->entityManager->getRepository(Booking::class)->findBy(['BeginAt'=> $desiredDate]);

    //             // Puis, vous pouvez rediriger vers une vue qui affiche à la fois le calendrier mis à jour et un message de confirmation
//             return $this->render('booking_new/confirmation.html.twig', [
//                 'form' => $form->createView(),
//                 'calendar' => $calendarData,
//                 'confirmationMessage' => 'Votre réservation a été ajoutée avec succès.'
//             ]);
//         }

    //         // Affichez le formulaire dans le modèle Twig dédié à la création de nouvelles réservations
//         return $this->render('booking_new/index.html.twig', [
//             'form' => $form->createView(),


    //         ]);
//     }

}
