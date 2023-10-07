<?php

namespace App;


class Helper
{

    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function shortName($name)
    {
//        var_dump($customer);
        $explodeName = explode(' ', $name);

        $firstLetterOfFirstName = $explodeName[0][0] ?? '';
        $firstLetterOfLastName = $explodeName[1][0] ?? '';

        return $firstLetterOfFirstName . $firstLetterOfLastName;
    }

    public static function getLoggedInUserShortName($name){
       return self::shortName($name);
    }


}

