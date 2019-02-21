<?php
$collection = new uber\Core\Router\RouteCollection();

$collection->add('start', new uber\Core\Router\Route(
    //Url
    HTTP_SERVER.'',
    [
        //Name of controller file (starts in app/Http/Controller/)
        'file' => 'MainController.php',
        //Name of controller class (Namespace starts in app\Http\Controller)
        'class' => 'MainController',
        //Name of function in assigned class
        'method' => 'start'
    ]
));

$collection->add('panel', new uber\Core\Router\Route(
    HTTP_SERVER.'panel',
    [
        'file' => 'MainController.php',
        'class' => 'MainController',
        'method' => 'panel'
    ]
));

$collection->add('signIn', new \uber\Core\Router\Route(
    HTTP_SERVER.'sign-in',
    [
        'file' => 'User/AccountController.php',
        'class' => 'User\AccountController',
        'method' => 'signIn'
    ]
));

$collection->add('signUp', new \uber\Core\Router\Route(
    HTTP_SERVER.'sign-up',
    [
        'file' => 'User/AccountController.php',
        'class' => 'User\AccountController',
        'method' => 'signUp'
    ]
));

$collection->add('displayEntries', new uber\Core\Router\Route(
    HTTP_SERVER.'panel/entries',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'displayAction'
    ]
));

$collection->add('addEntry', new uber\Core\Router\Route(
    HTTP_SERVER.'panel/entries/add',
    [
        'file' => 'EntriesController.php',
        'class' => 'EntriesController',
        'method' => 'addAction'
    ]
));

$collection->add('removeEntry', new uber\Core\Router\Route(
    HTTP_SERVER.'panel/entries/remove/{id}',
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