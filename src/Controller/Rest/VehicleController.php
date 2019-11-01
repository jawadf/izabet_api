<?php

namespace App\Controller\Rest;

use App\Entity\Vehicle;
use App\Service\VehicleService;
use App\Service\CheckerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;


class VehicleController extends FOSRestController
{
    
    private $vehicleService;
    private $checkerService;
   
    public function __construct(VehicleService $vehicleService, CheckerService $checkerService)
    {
        $this->vehicleService = $vehicleService;
        $this->checkerService = $checkerService;
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

        $checker = $this->checkerService->checker($deviceId, $type, $salt);

        $vehicle = array();
        if ($checker['status']) {
            $user = $checker['user'];
            $vehicle = $this->vehicleService->addVehicle($vehicleNumber, $vehicleCode, $vehicleName, $type, $user);
            // Todo: 400 response - Invalid Input
            // Todo: 404 response - Resource not found
        }

        return View::create($vehicle, Response::HTTP_CREATED);
    }


    /**
     * Get all Vehicle resources of the current user
     * @Rest\Get("/vehicles")
     */
    public function getUserVehicles(Request $request): View
    {
        $deviceId = $request->get('device_id');
        $type = $request->get('type');
        $salt = $request->get('salt');

        $checker = $this->checkerService->checker($deviceId, $type, $salt);

        $vehicles = array();
        if ($checker['status']) {
            $user = $checker['user'];
            $vehicles = $this->vehicleService->getUserVehicles($user, $type);

        }

        return View::create($vehicles, Response::HTTP_CREATED);
    }

    /**
     * Delete a Vehicle resource
     * @Rest\Delete("/vehicles")
     */
    public function deleteVehicle(Request $request): View
    {
        $deviceId = $request->get('device_id');
        $type = $request->get('type');
        $salt = $request->get('salt');
        $vehicleId = $request->get('id');

        $checker = $this->checkerService->checker($deviceId, $type, $salt);

        $result = array();
        if ($checker['status']) {
            $result = $this->vehicleService->deleteVehicle($vehicleId);

        }

        return View::create($result, Response::HTTP_CREATED);

    }


}