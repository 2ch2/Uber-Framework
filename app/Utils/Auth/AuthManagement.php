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
     * @var int
     */
    protected $id;

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

        if ($this->session->isSessionExists('u_id')) {
            $this->isLogged = true;
            $this->id = $this->session->get('u_id');
        }
    }

    public function createUserSession($id)
    {
        if (!$this->isLogged) {
            $this->session->start();
            $this->session->set('u_id', $id);
            $this->session->assign();
        }
    }

    public function loadUserData()
    {
        if ($this->isLogged) {
            try {
                /**
                 * @var $model AccountModel
                 */
                $model = $this->entityManager->find('app\Model\User\AccountModel', $this->id);
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getRank(): string
    {
        return $this->rank;
    }
}