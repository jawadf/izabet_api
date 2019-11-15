<?php

namespace App\Service;

use App\Entity\UsersAnd;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
        
        $result = array();
        if($user) {

            $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $password);
            if($isPasswordValid) {
                $result[] = [
                    'message' => 'Login successful!',
                    'success' => 1,
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'token' => $user->getApiToken()
                ];
            } else {
                $result[] = [
                    'message' => 'Sorry! Invalid password.',
                    'success' => 0
                ];
            }

        } else {
            $result[] = [
                'message' => 'Sorry! Invalid email.',
                'success' => 0
            ];
        }

        echo json_encode($result);
    }


    /**
     * Used for sign up
     * 
     */
    public function registerMethod($email, $password, $deviceId, $deviceName, $validator)
    {
        $return = array();
        if ($email && $password && $deviceId && $deviceName) {
        
            $userExists = $this->usersRepository->findOneBy([
                'email' => $email
            ]);

            if($userExists) {
                $return[] = array('message' => 'User already exists', 'success' => 0);
            } else {
                $user = new UsersAnd();
                $user->setEmail($email);
                $user->setPassword($this->passwordEncoder->encodePassword( $user, $password ));
                $user->setApiToken(md5(uniqid(rand(), true)));
                $user->setCreateDate(new \DateTime());
                $user->setDeviceId($deviceId);
                $user->setDeviceName($deviceName);

                $errors = $validator->validate($user);

                if (count($errors) > 0) {
                    /*
                    * Uses a __toString method on the $errors variable which is a
                    * ConstraintViolationList object. This gives us a nice string
                    * for debugging.
                    */                    

                    $return[] = [
                        'message' => 'Invalid input',
          
                        'success' => 0
                    ];

                    // // Map through erros and display each one

                    // foreach($errors as $error) {
                    //     $errorString = (string) $error;
                    //     $return[0]['errors'][] = $errorString;
                    // }
 

                } else {

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    $return[] = [
                        'message' => 'User successfully registered!',
                        'success' => 1,
                        'id' => $user->getId(),
                        'email' => $user->getEmail(),
                        'token' => $user->getApiToken()
                    ];

                }
            }
          //  return $return;

         } else {
            $return[] = array('success' => 0, 'message' => 'Registration error!');
         //   return $return;
        }

        echo json_encode($return);
    }


}