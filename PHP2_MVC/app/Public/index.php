<?php 
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/core/bootstrap.php';


$_SERVER['REQUEST_URI'] = '/' . trim($_SERVER['REQUEST_URI'], '/');

$router = new Router();
$router->disPatch($_SERVER["REQUEST_URI"]);

