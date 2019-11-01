<?php

namespace App\Service; 

use App\Entity\UsersAndroid;
use Doctrine\ORM\EntityManagerInterface;

class CheckerService
{    
    
    private $usersAndroidRepository;
    
    public function __construct(EntityManagerInterface $entityManager) {
        $this->usersAndroidRepository = $entityManager->getRepository(UsersAndroid::class);
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
}