<?php

namespace App\Service;

use App\Entity\UsersAnd;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class LoginService
{ 
    
    private $usersRepository;
    
    private $entityManager;

    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder) {
        $this->usersRepository = $entityManager->getRepository(UsersAnd::class);
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * Check for username and password, return Token
     * 
     */
    public function loginMethod($email, $password)
    {

        $user = $this->usersRepository->findOneBy([
            'email' => $email
        ]);

        $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $password);
        
        $result = array();
        if($isPasswordValid) {

            $result[] = [
                'Message' => 'success',
                'email' => $user->getEmail(),
                'token' => $user->getApiToken(),
                'isPasswordValid' => $isPasswordValid
            ];

        } else {
            $result[] = [
                'Message' => 'Sorry! Invalid email or password'
            ];
        }

        echo json_encode($result);
    }


    /**
     * Used for sign up
     * 
     */
    public function registerMethod($email, $password, $deviceId, $deviceName)
    {
        $return = array();
         if ($email && $password && $deviceId && $deviceName) {
        
            $userExists = $this->usersRepository->findOneBy([
                'email' => $email
            ]);

            if($userExists) {
                $return = array('message' => 'User already exists');
            } else {
                $user = new UsersAnd();
                $user->setEmail($email);
                $user->setPassword($this->passwordEncoder->encodePassword( $user, $password ));
                $user->setApiToken(md5(uniqid(rand(), true)));
                $user->setCreateDate(new \DateTime());
                $user->setDeviceId($deviceId);
                $user->setDeviceName($deviceName);

                $this->entityManager->persist($user);
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


}