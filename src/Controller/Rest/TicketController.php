<?php

namespace App\Controller\Rest;

use App\Entity\Ticket;
use App\Service\TicketService;
use App\Service\CheckerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;


class TicketController extends FOSRestController
{

    private $ticketService;
    private $checkerService;
   
    public function __construct(TicketService $ticketService, CheckerService $checkerService)
    {
        $this->ticketService = $ticketService;
        $this->checkerService = $checkerService;
    }
    
    /**
     * Check for tickets
     * @Rest\Get("/tickets")
     */ 
    public function checkViolations(Request $request): View
    {
        $deviceId = $request->get('device_id');
        $type = $request->get('type');
        $vehicleNumber = $request->get('vehicle_number');
        $vehicleCode = $request->get('vehicle_code');

        $checker = $this->checkerService->checker($deviceId, $type);

        $results = array();
        if ($checker['status']) {
            $results = $this->ticketService->checkViolations($vehicleNumber, $vehicleCode);
        }

        return View::create($results, Response::HTTP_CREATED);
    }


}
