<?php

include __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/src/config.php';
require_once __DIR__.'/src/routes.php';

$router = new \Core\Router\Router(SERVER_PROTOCOL.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);

$router->run();

$file = $router->getFile();
$class = $router->getClass();
$method = $router->getMethod();

if(file_exists($file)){
    require_once $file;
    $obj = new $class();
    $obj->$method();
}else{
    echo 'Page not found.';
}