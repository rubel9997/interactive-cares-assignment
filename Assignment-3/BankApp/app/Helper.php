<?php

namespace App;

class Helper{

    public static function emailValidator($email){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }

}
