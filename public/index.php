<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Core\Application;

require __DIR__ . '/../App/autoload.php';

$container = new \App\Core\Container();
$application = $container->get('App\Core\Application');
$application->run();
