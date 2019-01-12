<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
    define('SERVER_PROTOCOL', 'http');
} else {
    define('SERVER_PROTOCOL', 'https');
}