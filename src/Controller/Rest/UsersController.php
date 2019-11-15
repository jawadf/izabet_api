<?php

namespace App\Controller\Rest;

use App\Entity\UsersAnd;
use App\Service\LoginService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\View\View;


class UsersController extends FOSRestController
{

    private $loginService;
   
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @Rest\Get("/login")
     */ 
    public function loginHandler(Request $request): View
    {
        $email = $request->get('email');
        $password = $request->get('password');
        
        $result = $this->loginService->loginMethod($email, $password);

        return View::create($result, Response::HTTP_CREATED);
    }


    /**
     * @Rest\Post("/register")
     */ 
    public function registerHandler(Request $request, ValidatorInterface $validator): View
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $deviceId = $request->get('device_id');
        $deviceName = $request->get('device_name');

        $result = $this->loginService->registerMethod($email, $password, $deviceId, $deviceName, $validator);

        return View::create($result, Response::HTTP_CREATED);
    }

}
