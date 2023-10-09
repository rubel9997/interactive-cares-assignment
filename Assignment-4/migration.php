<?php 
require_once "vendor/autoload.php";

use App\WEB\Storage\DB;


$migration = new \App\WEB\Database\Migration(new DB);

$migration->run();