<?php

namespace App\CLI;

class User
{
    private string $name;
    private string $email;
    private string $password;

    protected string $role;

    public static function getModelName(): string
    {
        return 'users';
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_DEFAULT);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setRole(string $role){
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }

}