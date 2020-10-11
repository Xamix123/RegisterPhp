<?php

error_reporting(E_CORE_ERROR);
ini_set('display_errors', 1);
require __DIR__ . '/vendor/autoload.php';

session_start();

define('ROOT', dirname(__FILE__));

use testTask1\app\components\Router;

$router = new Router();
$router->run();
