<?php

namespace app\Http\Controller;

/**
 * Main Controller, includes the most
 * basic's routes methods.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class MainController extends \uber\Http\Controller
{
    public function start()
    {
        $this->render('Main/start.html.twig');
        session_start();
        if(isset($_SESSION['u_id']))
            echo $_SESSION['u_id'];
    }

    public function panel()
    {
        $this->render('Main/panel.html.twig');
    }
}