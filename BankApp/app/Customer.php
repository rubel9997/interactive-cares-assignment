<?php


namespace App;

use App\CustomerRole;


class Customer
{

    private string $name;
    private string $email;
    private string $password;

    protected CustomerRole $role;

    public static function getModelName(): string
    {
        return 'customers';
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

    public function setRole(CustomerRole $role): void{
        $this->role = $role;
    }

    public function getRole(): CustomerRole
    {
        return $this->role;
    }


}