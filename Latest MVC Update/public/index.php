<?php

session_start();

$min_PHP_version = 8.0;
if(phpversion() < $min_PHP_version)
    die("PHP version must be " . $min_PHP_version . ". Yours is " . phpversion());


    
require "../app/core/init.php";

(DEBUG) ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$app = new App;
$app->load_controller();