#! /usr/bin/env php

<?php

require_once "vendor/autoload.php";

use App\BankApp;

$bankApp = new BankApp();

$bankApp->adminRun();