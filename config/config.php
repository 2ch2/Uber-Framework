<?php

//Here write your domain with correct protocol (https://example.com/)
define('HTTP_SERVER', 'http://localhost/UberFramework/');

//Check for debug mode
define('DEBUG_MODE', true);

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
    'dir' => __DIR__ . '/../app/View/',
    'cache' => __DIR__.'/../cache'
]);

//Set correct server protocol
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
    define('SERVER_PROTOCOL', 'http');
} else {
    define('SERVER_PROTOCOL', 'https');
}