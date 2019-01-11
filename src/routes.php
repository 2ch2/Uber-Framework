<?php
$collection = new \Core\Router\RouteCollection();

$collection->add('home', new \Core\Router\Route(
    //Url
    HTTP_SERVER.'',
    [
        //Name of controller file (starts in src/Controller/)
        'file' => 'MainController.php',
        //Name of controller class (Namespace starts in Controller\\)
        'class' => 'MainController',
        //Name of function in assigned class
        'method' => 'start'
    ]
));

$router = new \Core\Router\Router($_SERVER['REQUEST_URI'], $collection);