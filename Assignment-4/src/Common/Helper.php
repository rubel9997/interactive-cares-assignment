<?php

namespace App\Common;


class Helper
{

    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function shortName($name)
    {

        $explodeName = explode(' ', $name);

        $firstLetterOfFirstName = $explodeName[0][0] ?? '';
        $firstLetterOfLastName = $explodeName[1][0] ?? '';

        return strtoupper($firstLetterOfFirstName . $firstLetterOfLastName);
    }

}

