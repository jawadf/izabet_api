<?php

namespace App\Controller\Rest;

use App\Entity\Vehicle;
use App\Service\VehicleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;


class VehicleController extends FOSRestController
{
    
    private $vehicleService;
   
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }


    /**
     * Creates an Vehicle resource
     * @Rest\Post("/vehicles")
    */
    public function addVehicle(Request $request): View
    {

        $deviceId = $request->get('device_id');
        $type = $request->get('type');
        $salt = $request->get('salt');
        $vehicleNumber = $request->get('vehicle_number');
        $vehicleCode = $request->get('vehicle_code');
        $vehicleName = $request->get('vehicle_name');

        $checker = $this->vehicleService->checker($deviceId, $type, $salt);

        $vehicle = array();
        if ($checker['status']) {
            $user = $checker['user'];
            $vehicle = $this->vehicleService->addVehicle($vehicleNumber, $vehicleCode, $vehicleName, $type, $user);
            // Todo: 400 response - Invalid Input
            // Todo: 404 response - Resource not found
        }

        return View::create($vehicle, Response::HTTP_CREATED);
    }

}