<?php

require_once "vendor/autoload.php";
require_once __DIR__."/src/Routes/Routes.php";

\App\Session::init();
//session_start();
use App\Routes\Router;



Router::run();

