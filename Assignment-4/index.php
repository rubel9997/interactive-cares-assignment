<?php

require_once "vendor/autoload.php";
require_once __DIR__ . "/src/WEB/Routes/Routes.php";

\App\WEB\Session::init();
use App\WEB\Routes\Router;


Router::run();

