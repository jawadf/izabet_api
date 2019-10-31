<?php

namespace App\Service; 

use App\Entity\Vehicle;
use App\Entity\UsersAndroid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class VehicleService
{

    private $vehicleRepository;

    private $usersAndroidRepository;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->vehicleRepository = $entityManager->getRepository(Vehicle::class);
        $this->usersAndroidRepository = $entityManager->getRepository(UsersAndroid::class);
        $this->entityManager = $entityManager;
    }

    /**
     *  GENERAL CHECKER (For some URL parameters)
    */
    public function checker(string $deviceId, int $type, int $salt) 
    {
        if($type == 2) {
            $user = $this->usersAndroidRepository->findOneBy([
                'deviceId' => $deviceId,
                'salt' => $salt
            ]);
            
            if ($user) {
                return array('status' => true, 'user' => $user );
            } else {
                return array( 'status' => false );
            }
        }
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
    public function addVehicle(int $vehicleNumber, string $vehicleCode, string $vehicleName, int $type, UsersAndroid $user)
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

    public function getUserVehicles(): ?array
    {
        return $this->vehicleRepository->findAll();
    }

    public function deleteVehicle(int $vehicleId): void
    {
        $vehicle = $this->vehicleRepository->find($vehicleId);
        if ($vehicle) {
            $this->entityManager->remove($vehicle);
            $this->entityManager->flush();
        } else if (!$vehicle) {
            throw new EntityNotFoundException('Vehicle with id '.$vehicleId.' does not exist!');
        }
    }

}