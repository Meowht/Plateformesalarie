<?php

namespace App\EventSubscriber;

use App\Repository\BookingRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private BookingRepository $bookingRepository,
        private UrlGeneratorInterface $router
    )
    {}

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $bookings = $this->bookingRepository
            ->createQueryBuilder('booking')
            ->where('booking.beginAt BETWEEN :start and :end OR booking.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        $uniqueDates = []; // Tableau pour stocker les dates uniques des réservations
        $eventsAdded = 0; // Compteur pour le nombre d'événements ajoutés

        foreach ($bookings as $booking) {
            $dateKey = $booking->getBeginAt()->format('Y-m-d');

            // Vérifiez si la date n'a pas encore été ajoutée au tableau des dates uniques
            if (!in_array($dateKey, $uniqueDates)) {
                $uniqueDates[] = $dateKey; // Ajoutez la date au tableau des dates uniques
                $eventsAdded++;

                $bookingEvent = new Event(
                    $booking->getTitle(),
                    $booking->getBeginAt(),
                    $booking->getEndAt()
                );

                /*
                 * Add custom options to events
                 *
                 * For more information, see: https://fullcalendar.io/docs/event-object
                 * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
                 */

                $bookingEvent->setOptions([
                    'backgroundColor' => '#1D8DF6',
                    'borderColor' => '#1D8DF6',
                ]);
                $bookingEvent->addOption(
                    'url',
                    $this->router->generate('app_booking_edit', [ // Change 'app_booking_new' to your route name
                        'id' => $booking->getId(),
                    ])
                );

                // Ajoutez l'événement au calendrier
                $calendar->addEvent($bookingEvent);

                if ($eventsAdded >= 5) {
                    break; // Limite atteinte pour les événements uniques
                }
            }
        }

        // Ajoutez vos événements personnalisés ici
        // $customEvent = new Event(
        //     'Custom Event',
        //     new \DateTime('2023-10-31 10:00:00'),
        //     new \DateTime('2023-10-31 12:00:00')
        // );

        // $customEvent->setOptions([
        //     'backgroundColor' => 'blue',
        //     'borderColor' => 'blue',
        // ]);
        // $customEvent->addOption(
        //     'url',
        //     $this->router->generate('app_booking', [
        //         'parameter' => 'value',
        //     ])
        // );

        // $calendar->addEvent($customEvent);
    }
}
