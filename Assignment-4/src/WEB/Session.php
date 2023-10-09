<?php


namespace App\WEB;


class Session
{
    public static function init()
    {
        session_start();
    }
    public static function set($key,$value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function unset()
    {
         session_unset();
    }

    public static function destroy():void
    {

        session_destroy();
    }

}