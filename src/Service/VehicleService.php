<?php

namespace App\Service; 

use App\Entity\Vehicle;
use App\Entity\UsersAnd;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;


class VehicleService
{
    
    private $vehicleRepository;
    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->vehicleRepository = $entityManager->getRepository(Vehicle::class);
        $this->entityManager = $entityManager;
    }

    /**
     * ADD VEHICLE 
     * 
     * @param vehicleNumber
     * @param vehicleCode
     * @param vehicleName
     * 
     * @return success
     */
    public function addVehicle(int $vehicleNumber, string $vehicleCode, string $vehicleName, int $type, UsersAnd $user)
    {
        $return = array();
         if (strlen($vehicleNumber) > 2 and $vehicleCode and $vehicleName) {

            $vehicleExists = $this->vehicleRepository->findOneBy([
                'vehicleId' => $vehicleNumber,
                'vehicleCode' => $vehicleCode,
                'vehicleName' => $vehicleName
            ]);

            if($vehicleExists) {
                $return = array('message' => 'Vehicle already exists');
            } else {
                $vehicle = new Vehicle();
                $vehicle->setVehicleId($vehicleNumber);
                $vehicle->setVehicleCode($vehicleCode);
                $vehicle->setVehicleName($vehicleName);
                $vehicle->setCreateDate(new \DateTime());
                $vehicle->setUserOs($type);
                $vehicle->setUser($user);

                $this->entityManager->persist($vehicle);
                $this->entityManager->flush();

                $return = array('success' => 1);
            }

            return $return;

         } else {
             $return = array('success' => 0);
             return $return;
         }

         echo json_encode($return);
    }


    /**
     * GET VEHICLES OF A SPECIFIC USER
     * 
     */
    public function getUserVehicles($user, $type)
    {
        $result = $this->vehicleRepository->findBy(
            ['user' => $user]
            // To do: add Type
        );

        $vehicles = array();
        foreach ($result as $oneVehicle) {
            $vehicles[] = [
               'id' => $oneVehicle->getId(),
               'status' => $oneVehicle->getStatus(),
               'create_date' => $oneVehicle->getCreateDate()->format('Y-m-d H:i:s'),
               'vehicle_id' => $oneVehicle->getVehicleId(),
               'vehicle_code' => $oneVehicle->getVehicleCode(),
               'vehicle_name' => $oneVehicle->getVehicleName(),
               'user_id' => $oneVehicle->getUser()->getId(),
               'user_os' => $oneVehicle->getUserOs(),
            ];
        }

        echo json_encode($vehicles);
    }

    /**
     * DELETE VEHICLE
     * 
     */
    public function deleteVehicle(int $vehicleId): void
    {
        $vehicle = $this->vehicleRepository->find($vehicleId);
        
        $return = array();
        if ($vehicle) {
            $this->entityManager->remove($vehicle);
            $this->entityManager->flush();
            $return = ['isDeleted' => 1];
        } else if (!$vehicle) {
            $return = ['isDeleted' => 0, 'message' => 'Vehicle with id '.$vehicleId.' does not exist!'];
        }

        echo json_encode($return);
    }

}