<?php

namespace app\Utils\Auth;

use app\Model\User\AccountModel;
use Doctrine\ORM\EntityManager;
use uber\Utils\DataManagement\SessionManager;
use uber\Utils\ExceptionUtils;

/**
 * Manager for logged user.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class AuthManager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var SessionManager
     */
    protected $session;

    /**
     * @var bool
     */
    protected $isLogged = false;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->session = new SessionManager();
        $this->isLogged = $this->isLogged();

        if ($this->isLogged) {
            $this->isLogged = true;
            $this->loadUserSession();
        }
    }

    public function createUserSession($id)
    {
        if (!$this->isLogged) {
            $this->session->set('user', true);
            $this->session->set('user_id', $id);
            $this->session->assign();
        }
    }

    public function destroyUserSession()
    {
        if ($this->isLogged) {
            $this->session->unset('user');
            $this->session->unset('user_id');
            $this->session->unset('user_username');
            $this->session->unset('user_rank');
            $this->session->unset('user_email');
            $this->session->unset('user_joined');
            $this->session->unset('user_recentActivity');
            $this->session->assign();
        }
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if ($this->session->isSessionExists('user'))
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
                $model = $this->entityManager->find('app\Model\User\AccountModel', $this->session->get('user_id'));
            } catch (\Exception $exception) {
                ExceptionUtils::displayExceptionMessage($exception);
                exit;
            }

            if (!empty($model)) {
                $this->session->set('user_username', $model->getUsername());
                $this->session->set('user_rank', $model->getRank());
                $this->session->set('user_email', $model->getEmail());
                $this->session->set('user_joined', $model->getJoined());
                $this->session->set('user_recentActivity', $model->getRecentActivity());
                $this->session->assign();

                try {
                    $model->setRecentActivity();
                    $this->entityManager->flush($model);
                } catch (\Exception $exception) {
                    ExceptionUtils::displayExceptionMessage($exception);
                }
            }
        }
    }
}