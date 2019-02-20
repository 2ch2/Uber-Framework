<?php

namespace app\Http\Controller\User;

use app\Model\User\AccountModel;
use app\Utils\Auth\UserAuthorization;
use uber\Http\Controller;
use uber\Utils\DataManagement\VariablesManagement;
use uber\Utils\ExceptionUtils;

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

    public function login()
    {
        if ($this->isAjax) {
            $em = $this->getEntityManager();
            $auth = new UserAuthorization($em);

        } else
            $this->render('User/Login/loginForm.html.twig');
    }

    public function signUp()
    {
        if ($this->isAjax) {
            $em = $this->getEntityManager();
            $auth = new UserAuthorization($em);
            $auth->authSignIn($this->variables->post('username'), $this->variables->post('email'), $this->variables->post('password'), $this->variables->post('repeatPassword'));

            if ($auth->getResults() && !$auth->getErrors()) {
                $model = new AccountModel();
                $model->setUsername($auth->getResults()['username']);
                $model->setPassword($auth->getResults()['password']);
                $model->setEmail($auth->getResults()['email']);

                try {
                    $model->setJoined();
                    $model->setRecentActivity();
                } catch (\Exception $exception) {
                    ExceptionUtils::displayExceptionMessage($exception);
                }

                try {
                    $em->persist($model);
                    $em->flush();
                } catch (\Exception $exception) {
                    ExceptionUtils::displayExceptionMessage($exception);
                }
            }

            $this->render('User/SignUp/signUpAjax.html.twig', [
                'errors' => $auth->getErrors(),
                'username' => $this->variables->post('username'),
                'email' => $this->variables->post('email'),
            ]);
        } else
            $this->render('User/SignUp/signUpForm.html.twig');
    }
}