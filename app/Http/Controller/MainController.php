<?php

namespace app\Http\Controller;

/**
 * Main Controller, includes the most
 * basic's routes methods.
 *
 * Class MainController
 *
 * @category Controller
 *
 * @package app\Http\Controller
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/kamil-ubermade/Uber-Framework
 */
class MainController extends \uber\Http\MainController
{
    public function start()
    {
        $this->render('Main/start.html.twig');
    }
}