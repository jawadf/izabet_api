<?php

namespace App\Service; 

use App\Entity\UsersAnd;
use Doctrine\ORM\EntityManagerInterface;

class CheckerService
{    
    
    private $usersAndroidRepository;
    
    public function __construct(EntityManagerInterface $entityManager) {
        $this->usersAndroidRepository = $entityManager->getRepository(UsersAnd::class);
    }

    /**
     *  Checks if there's a User with this device id
     */
    public function checker(string $deviceId, int $type) 
    {
        if($type == 2) {
            $user = $this->usersAndroidRepository->findOneBy([
                'deviceId' => $deviceId
            ]);
            
            if ($user) {
                return array('status' => true, 'user' => $user );
            } else {
                return array( 'status' => false );
            }
        }
    }
}