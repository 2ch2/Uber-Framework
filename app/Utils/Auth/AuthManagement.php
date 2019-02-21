<?php

namespace app\Utils\Auth;

use app\Model\User\AccountModel;
use Doctrine\ORM\EntityManager;
use uber\Utils\DataManagement\Session;
use uber\Utils\ExceptionUtils;

/**
 * Manager for logged user.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class AuthManagement
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var bool
     */
    protected $isLogged = false;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $rank;

    /**
     * @var int
     */
    protected $userId;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->session = new Session();

        $this->checkIsLogged();
    }

    public function loadUserData($id)
    {

    }

    public function updateUserData($id)
    {
        if($this->isLogged)
        {
            try {
                /**
                 * @var $model AccountModel
                 */
                $model = $this->entityManager->find('app\Model\User\AccountModel', $id);
            } catch (\Exception $exception) {
                ExceptionUtils::displayExceptionMessage($exception);
                exit;
            }

            if (!empty($model)) {
                $this->username = $model->getUsername();
                $this->email = $model->getEmail();
                $this->rank = $model->getRank();
            }
        }
    }

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->isLogged;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    private function checkIsLogged(): bool
    {
        if (!$this->session->isSessionExists('u_id')) {
            $this->isLogged = true;

            $this->session->start();
            $this->session->set('u_id', $model->getId());
            $this->session->assign();
        }
    }
}