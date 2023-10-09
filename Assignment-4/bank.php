#! /usr/bin/env php

<?php
require_once "vendor/autoload.php";

use App\CLI\CLIBankApp;


$bank_app = new CLIBankApp();

$bank_app->run();