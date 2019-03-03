<?php

namespace app\Utils\Auth;

use app\Model\User\AccountModel;
use Doctrine\ORM\EntityManager;
use uber\Core\Router\UrlGenerator;
use uber\Utils\DataManagement\SessionManager;
use uber\Utils\ExceptionUtils;

/**
 * Manager for logged user.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class UserAuthManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * @var bool
     */
    private $isLogged = false;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->sessionManager = new SessionManager();
        $this->urlGenerator = new UrlGenerator();
        $this->isLogged = $this->isLogged();

        if ($this->isLogged) {
            $this->isLogged = true;
            $this->loadUserSession();
        }
    }

    public function createUserSession($id)
    {
        if (!$this->isLogged) {
            $this->sessionManager->set('user', true);
            $this->sessionManager->set('user_id', $id);
            $this->sessionManager->assign();
        }
    }

    public function destroyUserSession()
    {
        if ($this->isLogged) {
            $this->sessionManager->unset('user');
            $this->sessionManager->unset('user_id');
            $this->sessionManager->unset('user_username');
            $this->sessionManager->unset('user_rank');
            $this->sessionManager->unset('user_email');
            $this->sessionManager->unset('user_joined');
            $this->sessionManager->unset('user_recentActivity');
            $this->sessionManager->assign();
        }
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if ($this->sessionManager->isSessionExists('user'))
            return true;

        return false;
    }

    private function loadUserSession()
    {
        if ($this->isLogged) {
            try {
                /**
                 * @var $model AccountModel
                 */
                $model = $this->entityManager->find('app\Model\User\AccountModel', $this->sessionManager->get('user_id'));
            } catch (\Exception $exception) {
                ExceptionUtils::displayExceptionMessage($exception);
                exit;
            }

            if (!empty($model)) {
                $this->sessionManager->set('user_username', $model->getUsername());
                $this->sessionManager->set('user_rank', $model->getRankId());
                $this->sessionManager->set('user_email', $model->getEmail());
                $this->sessionManager->set('user_joined', $model->getJoined());
                $this->sessionManager->set('user_recentActivity', $model->getRecentActivity());
                $this->sessionManager->assign();

                try {
                    $model->setRecentActivity();
                    $this->entityManager->flush($model);
                } catch (\Exception $exception) {
                    ExceptionUtils::displayExceptionMessage($exception);
                }
            } else {
                $this->destroyUserSession();
                $this->urlGenerator->redirect('start');
            }
        }
    }
}