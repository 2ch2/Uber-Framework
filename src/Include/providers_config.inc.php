<?php

return[
    //Set cache and starting dir destination for twig
    'twig' => [
        'dir' => __DIR__.'/../',
        'cache' => __DIR__.'/../../cache'
    ],

    //Set database connect data
    'database' => [
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => '',
        'dbname' => 'mvc-engine',
    ]
];