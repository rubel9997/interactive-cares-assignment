<?php


namespace App\Common\Repository;


interface UserRepository
{
    public function get(array $data);
    public function save(array $data);

}
