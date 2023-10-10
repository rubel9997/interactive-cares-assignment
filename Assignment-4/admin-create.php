#! /usr/bin/env php

<?php

require_once "vendor/autoload.php";

use App\CLI\CLIBankApp;

$bankApp = new CLIBankApp();

$bankApp->adminRun();