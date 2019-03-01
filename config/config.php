<?php

//Set name for your project
define('PROJECT_NAME', 'Uber-Framework');

//Check for debug mode
define('DEBUG_MODE', true);

//Defines resources dir
define('RESOURCES_DIR', __DIR__ . '/../resources/');

//Set database connect data
define('DATABASE', [
    //'host' => '(localhost is default)',
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '',
    'dbname' => 'mvc-engine'
]);

//Set cache and starting dir destination for twig
define('TWIG', [
    'dir' => __DIR__ . '/../resources/View/',
    'cache' => __DIR__ . '/../cache'
]);

//Set correct server protocol
define('SERVER_PROTOCOL', (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') ? 'http://' : 'https://');

$server_uri_array = explode('/', $_SERVER['REQUEST_URI']);
$project_dir_name = PROJECT_NAME == $server_uri_array[1] ? '/' . PROJECT_NAME . '/' : '/';

//Defines http server url
define('HTTP_SERVER', SERVER_PROTOCOL . $_SERVER['HTTP_HOST'] . $project_dir_name);