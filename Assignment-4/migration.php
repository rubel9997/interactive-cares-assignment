<?php 
require_once "vendor/autoload.php";

use App\Storage\DB;



$migration = new App\Database\Migration(new DB);

$migration->run();