<?php
//use Dotenv\Dotenv;
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('Views_PATH', APP_PATH . '/views');
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('MODEL_PATH', APP_PATH . '/models');
define('CORE_PATH', APP_PATH . '/core');

$vendorAutoload = BASE_PATH . '/vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    require_once $vendorAutoload;
}

// $dotenv = Dotenv::createImmutable(BASE_PATH);
// $dotenv->load();

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'myconfig');
// $dotenv->load();

if (class_exists(\Dotenv\Dotenv::class)){
    \Dotenv\Dotenv::createImmutable(BASE_PATH)->safeLoad();
}


spl_autoload_register(function (string $class): void {
    $paths = [
        APP_PATH . '/core' . $class . '.php',
        CORE_PATH . '/' . $class . '.php',
        CONTROLLER_PATH . '/' . $class . '.php',
        MODEL_PATH . '/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
