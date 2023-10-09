#! /usr/bin/env php

<?php

require_once "vendor/autoload.php";

use App\CLI\BankApp;

$bankApp = new BankApp();

$bankApp->adminRun();