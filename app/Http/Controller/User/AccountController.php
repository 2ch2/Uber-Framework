<?php

namespace app\Http\Controller\User;

use uber\Http\Controller;
use uber\Utils\DataManagement\VariablesManagement;

/**
 * Controller for registered accounts.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class AccountController extends Controller
{
    /**
     * @var VariablesManagement
     */
    private $variables;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->variables = new VariablesManagement();
    }

    public function signUp()
    {
        if($this->isAjax)
            echo $this->variables->post('username');
        else
            $this->render('User/register-form.html.twig');
    }
}