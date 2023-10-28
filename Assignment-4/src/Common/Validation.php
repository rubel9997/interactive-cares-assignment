<?php


namespace App\Common;


class Validation
{

    public function validated(string $data):string
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

}