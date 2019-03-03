<?php

namespace app\Http\Controller\User;

use app\Model\User\AccountModel;
use app\Utils\Auth\UserAuthManager;
use app\Utils\Auth\UserAuthorization;
use Doctrine\ORM\Query;
use uber\Core\Router\UrlGenerator;
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
    private $variablesManager;

    /**
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->variablesManager = new VariablesManager();
        $this->sessionManager = new SessionManager();
        $this->urlGenerator = new UrlGenerator();
    }

    public function displayAction()
    {
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder()
            ->select('a.username, a.email, a.recent_activity, a.joined, r.name AS rank')
            ->from('app\Model\User\AccountModel', 'a')
            ->leftJoin(
                'app\Model\User\RankModel',
                'r',
                Query\Expr\Join::WITH,
                'a.rank_id = r.id'
            )
            ->orderBy('a.id', 'DESC');

        $model = $qb->getQuery()->getResult();

        $this->render('User/displayAction.html.twig', [
            'users' => $model
        ]);
    }

    public function signIn()
    {
        if ($this->isAjax) {
            $em = $this->getEntityManager();
            $auth = new UserAuthorization($em);
            $auth->authSignIn($this->variablesManager->post('username'), $this->variablesManager->post('password'));

            if ($auth->getResults() && !$auth->getErrors()) {
                $authManagement = new UserAuthManager($em);
                $authManagement->createUserSession($auth->getResults()['id']);
            }

            $this->render('User/SignIn/signInAjax.html.twig', [
                'errors' => $auth->getErrors(),
                'username' => $this->variablesManager->post('username')
            ]);

        } else
            $this->render('User/SignIn/signInForm.html.twig');
    }

    public function signUp()
    {
        if ($this->isAjax) {
            $em = $this->getEntityManager();
            $auth = new UserAuthorization($em);
            $auth->authSignUp($this->variablesManager->post('username'), $this->variablesManager->post('email'), $this->variablesManager->post('password'), $this->variablesManager->post('repeatPassword'), $this->variablesManager->post('recaptchaResponse'));

            if ($auth->getResults() && !$auth->getErrors()) {
                $model = new AccountModel();
                $model->setUsername($auth->getResults()['username']);
                $model->setPassword($auth->getResults()['password']);
                $model->setRankId(1);
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
                'username' => $this->variablesManager->post('username'),
                'email' => $this->variablesManager->post('email'),
            ]);
        } else
            $this->render('User/SignUp/signUpForm.html.twig');
    }

    public function signOut()
    {
        if ($this->sessionManager->isSessionExists('user')) {
            $authManagement = new UserAuthManager($this->getEntityManager());
            $authManagement->destroyUserSession();
        }
        $this->urlGenerator->redirect('start');
    }
}