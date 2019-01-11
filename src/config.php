<?php

//Here write your domain with correct protocol (https://example.com/)
define('HTTP_SERVER', 'http://localhost/mvc-engine/');

//Check for debug mode
define('DEBUG_MODE', true);

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
    define('SERVER_PROTOCOL', 'http');
} else {
    define('SERVER_PROTOCOL', 'https');
}