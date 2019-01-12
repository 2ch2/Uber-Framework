<?php

namespace Controller;

use Core\App;
use Core\Router\UrlGenerator;

/**
 * Main Controller, includes the most
 * basic's routes methods.
 *
 * Class MainController
 *
 * @category Controller
 *
 * @package Controller
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/mvc-engine
 */
class MainController extends App
{
    public function start()
    {
        $urlGenerator = new UrlGenerator();
        echo $urlGenerator->generate('home');
    }
}