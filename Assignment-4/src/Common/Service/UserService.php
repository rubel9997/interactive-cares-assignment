<?php


namespace App\Common\Service;


use App\Common\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCustomer(array $data)
    {
        $this->userRepository->get($data);
    }


    public function create(array $data)
    {
        $this->userRepository->save($data);
    }
}