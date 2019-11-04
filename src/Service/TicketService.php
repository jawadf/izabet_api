<?php

namespace App\Service; 

use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class TicketService
{

    private $ticketRepository;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->ticketRepository = $entityManager->getRepository(Ticket::class);
        $this->entityManager = $entityManager;
    }

    public function checkViolations(int $vehicleNumber, string $vehicleCode) {

        $return = array();
        if (strlen($vehicleNumber) > 2 and $vehicleCode) {
            $currentVehicle = [
                'vehicle_number' => $vehicleNumber,
                'vehicle_code' => $vehicleCode
            ];
            $return['currentVehicle'][] = $currentVehicle;
            $tickets = $this->ticketRepository->findBy(
                ['vehicleId' => $vehicleNumber]
            );
            if($tickets) {
                foreach ($tickets as $oneTicket) {
                    $return['tickets'][] = [
                        'id' => $oneTicket->getId(),
                        'status' => $oneTicket->getStatus(),
                        'create_date' => $oneTicket->getCreateDate()->format('Y-m-d H:i:s'),
                        'update_date' => $oneTicket->getUpdateDate()->format('Y-m-d H:i:s'),
                        'vehicle_id' => $oneTicket->getVehicleId(),
                        'vehicle_code' => $oneTicket->getVehicleCode(),
                        'location' => $oneTicket->getLocation(),
                        'ticket_date' => $oneTicket->getTicketDate(),
                        'notification' => $oneTicket->getNotification(),
                    ];
                }
            } else {
                $return['tickets'][] = 0;
            }
        }
        echo json_encode($return);
    }


}

