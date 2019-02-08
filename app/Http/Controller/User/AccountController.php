<?php

namespace app\Http\Controller\User;

use uber\Http\Controller;

/**
 * Controller for registered accounts.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class AccountController extends Controller
{
    public function signUp()
    {
        $this->render('User/register-form.html.twig');
    }
}