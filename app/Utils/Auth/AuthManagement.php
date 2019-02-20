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
    protected $login;

    /**
     * @var string
     */
    protected $email;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->session = new Session();
    }

    public function createSessions($id)
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

        if(!empty($model)){
            $this->session->start();
            $this->session->set('u_id', $model->getId());
            $this->session->set('u_username', $model->getUsername());
            $this->session->set('u_email', $model->getEmail());

            $this->session->assign();
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
}