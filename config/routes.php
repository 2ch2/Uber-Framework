<?php
$collection = new uber\Core\Router\RouteCollection();

$collection->add('start', new uber\Core\Router\Route(
    //Url
    HTTP_SERVER.'',
    [
        //Name of controller file (starts in src/Controller/)
        'file' => 'Controller.php',
        //Name of controller class (Namespace starts in Controller)
        'class' => 'Controller',
        //Name of function in assigned class
        'method' => 'start'
    ]
));

$collection->add('displayEntries', new uber\Core\Router\Route(
    HTTP_SERVER.'entries',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'displayAction'
    ]
));

$collection->add('addEntry', new uber\Core\Router\Route(
    HTTP_SERVER.'entries/add',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'addAction'
    ]
));

$collection->add('removeEntry', new uber\Core\Router\Route(
    HTTP_SERVER.'entries/remove/{id}',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'removeAction'
    ],
    [
        'id' => '\d+'
    ],
    [
        'id' => '0'
    ]
));

$router = new uber\Core\Router\Router($_SERVER['REQUEST_URI'], $collection);