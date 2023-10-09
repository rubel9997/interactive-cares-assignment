<?php

namespace App\WEB\Controller\Auth;

use App\Common\Repository\UserDBRepository;
use App\Common\Service\UserService;

class AuthController
{
    protected UserService $user_service;
    public function __construct()
    {
        $this->user_service = new UserService(new UserDBRepository());

    }
}