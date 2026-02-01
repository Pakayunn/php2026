<?php 
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/core/bootstrap.php';

$router = new Router();
$router->disPatch($_SERVER["REQUEST_URI"]);
