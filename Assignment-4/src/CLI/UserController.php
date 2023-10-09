<?php

namespace App\CLI;

use App\Common\Helper;
use App\Common\UserRole;
use http\Encoding\Stream;

class UserController
{

    protected array $users;
    protected Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->users = $this->storage->load(User::getModelName());
        var_dump($this->users);
    }

    public function login(string $name,string $email)
    {

    }

    public function register(string $name,string $email,string $password)
    {

        if(empty($name) || empty($email) || empty($password)){
            printf(PHP_EOL);
            printf("All option are required.\n\n");
            return;
        }

        $exist_user = $this->existUser($email,UserRole::CUSTOMER);

        if($exist_user){
            printf(PHP_EOL);
            printf("This email is already exist.\n\n");
            return;
        }

        $emailValidation = Helper::validateEmail($email);

        if(!$emailValidation){
            printf(PHP_EOL);
            printf("Please Enter a valid email.\n\n");
            return;
        }

        if(strlen($password) < 2){
            printf(PHP_EOL);
            printf("Password must be at least 3 character.\n\n");
            return;
        }


        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRole(UserRole::CUSTOMER);

        $this->users[] = $user;

        $this->saveUser();

        printf("User registration successfully!\n\n");

    }

    public function existUser(string $email,string $role): ? User
    {
        foreach ($this->users as $user){
            if ($user->getEmail() == $email && $user->getRole() == $role) {
                return $user;
            }
        }
        return null;
    }

    public function saveUser()
    {
        $this->storage->save(User::getModelName(),$this->users);
    }




}