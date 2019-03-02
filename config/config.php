<?php

//Check for debug mode
define('DEBUG_MODE', true);

//Set database connect data
define('DATABASE', [
    'host' => $_ENV['DB_HOST'],
    'driver' => $_ENV['DB_DRIVER'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'dbname' => $_ENV['DB_NAME']
]);

//Defines resources dir
define('RESOURCES_DIR', __DIR__ . '/../resources/');

//Set cache and starting dir destination for twig
define('TWIG', [
    'dir' => __DIR__ . '/../resources/View/',
    'cache' => __DIR__ . '/../cache'
]);

//Set dir for your project (if any)
define('APP_DIR', $_ENV['APP_DIR']);

//Set correct server protocol
define('SERVER_PROTOCOL', (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') ? 'http://' : 'https://');

//Defines http server url
define('HTTP_SERVER', SERVER_PROTOCOL . $_SERVER['HTTP_HOST'] . APP_DIR . '/');

//Define recaptcha keys from https://www.google.com/recaptcha/intro/v3.html
define('RECAPTCHA_WEBSITE_KEY', $_ENV['RECAPTCHA_WEBSITE_KEY']);
define('RECAPTCHA_SECRET_KEY', $_ENV['RECAPTCHA_SECRET_KEY']);