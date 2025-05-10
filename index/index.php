<?php
require_once "../autoload.php";
use hitopenapi\app\core\app;


ob_start();

$app = new app();
$app->setrequest($_SERVER['REQUEST_METHOD']);
$app->init();

ob_flush();