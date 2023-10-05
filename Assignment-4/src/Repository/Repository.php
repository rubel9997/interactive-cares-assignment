<?php


namespace App\Repository;


interface Repository
{
    public function get();
    public function insert(array $data);
    public function update();
    public function delete();

}