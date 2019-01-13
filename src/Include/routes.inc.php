<?php
$collection = new \Core\Router\RouteCollection();

$collection->add('start', new \Core\Router\Route(
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

$collection->add('showEntries', new \Core\Router\Route(
    HTTP_SERVER.'entries',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'showEntries'
    ]
));

$collection->add('addEntry', new \Core\Router\Route(
    HTTP_SERVER.'entries/add',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'addEntry'
    ]
));

$collection->add('removeEntry', new \Core\Router\Route(
    HTTP_SERVER.'entries/remove/{id}',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'removeEntry'
    ],
    [
        'id' => '\d+'
    ],
    [
        'id' => '0'
    ]
));

$router = new \Core\Router\Router($_SERVER['REQUEST_URI'], $collection);