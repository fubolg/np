<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Core\Application;

require __DIR__ . '/../App/autoload.php';


$application = new Application();
$application->run();
