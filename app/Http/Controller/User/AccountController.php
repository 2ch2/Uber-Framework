<?php

namespace app\Http\Controller\User;

use app\Model\User\AccountModel;
use app\Model\User\RankModel;
use app\Utils\Auth\AuthManager;
use app\Utils\Auth\UserAuthorization;
use uber\Http\Controller;
use uber\Utils\DataManagement\SessionManager;
use uber\Utils\DataManagement\VariablesManager;
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
     * @var VariablesManager
     */
    private $variables;

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->variables = new VariablesManager();
        $this->session = new SessionManager();
    }

    public function signIn()
    {
        if ($this->isAjax) {
            $em = $this->getEntityManager();
            $auth = new UserAuthorization($em);
            $auth->authSignIn($this->variables->post('username'), $this->variables->post('password'));

            if ($auth->getResults() && !$auth->getErrors()) {
                $authManagement = new AuthManager($em);
                $authManagement->createUserSession($auth->getResults()['id']);
            }

            $this->render('User/SignIn/signInAjax.html.twig', [
                'errors' => $auth->getErrors(),
                'username' => $this->variables->post('username')
            ]);

        } else
            $this->render('User/SignIn/signInForm.html.twig');
    }

    public function signUp()
    {
        if ($this->isAjax) {
            $em = $this->getEntityManager();
            $auth = new UserAuthorization($em);
            $auth->authSignUp($this->variables->post('username'), $this->variables->post('email'), $this->variables->post('password'), $this->variables->post('repeatPassword'));

            if ($auth->getResults() && !$auth->getErrors()) {
                $model = new AccountModel();
                $model->setUsername($auth->getResults()['username']);
                $model->setPassword($auth->getResults()['password']);
                $model->setRank(1);
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

    public function signOut()
    {
        if ($this->session->isSessionExists('user')) {
            $authManagement = new AuthManager($this->getEntityManager());
            $authManagement->destroyUserSession();
        }
        $this->redirect('start');
    }
}