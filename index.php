<?php
declare(strict_types=1);

spl_autoload_register(function(string $classNamespace) {
    $path = str_replace(['\\', 'App/'], ['/', ''], $classNamespace);
    $path = "src/$path.php";
    
    if (file_exists($path)) require_once($path);
});

use App\Controllers\Controller;

require_once('./src/utils/debug.php');

session_start();

if (isset($_GET['c']) && isset($_GET['m'])) {
    $className = 'App\Controllers\\' . ucfirst($_GET['c']) . 'Controller';
    $method = $_GET['m'];

    if (!class_exists($className) || !method_exists($className, $method)) {
        $className = 'App\Controllers\IndexController';        
        $method = 'index';
    }
} else {
    $className = 'App\Controllers\IndexController';
    $method = 'index';
}

Controller::InitConfiguration(parse_ini_file('.env'));
$controller = new $className();
$controller->$method();

session_destroy();