<?php


namespace App;


class Validation
{

    public function validated($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

}