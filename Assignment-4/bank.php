#! /usr/bin/env php

<?php

require_once "vendor/autoload.php";

use App\CLI\BankApp;

$bank_app = new BankApp();

$bank_app->run();