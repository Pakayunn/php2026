<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//use Dotenv\Dotenv;
define('BASE_PATH', dirname(__DIR__, 2));

// BASE_URL: tự detect từ SCRIPT_NAME (ví dụ: /php2)
$_scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'), '/');
define('BASE_URL', $_scriptDir);
define('APP_PATH', BASE_PATH . '/app');
define('Views_PATH', APP_PATH . '/views');
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('MODEL_PATH', APP_PATH . '/models');
define('CORE_PATH', APP_PATH . '/core');
define('HELPERS_PATH', APP_PATH . '/helpers');

$vendorAutoload = BASE_PATH . '/vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    require_once $vendorAutoload;
}


if (class_exists(\Dotenv\Dotenv::class)){
    \Dotenv\Dotenv::createImmutable(BASE_PATH)->safeLoad();
}


spl_autoload_register(function (string $class): void {
    $paths = [
        APP_PATH . '/core' . $class . '.php',
        CORE_PATH . '/' . $class . '.php',
        CONTROLLER_PATH . '/' . $class . '.php',
        MODEL_PATH . '/' . $class . '.php',
        HELPERS_PATH . '/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});