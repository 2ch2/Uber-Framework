<?php

namespace app\Utils\Auth;

use app\Model\User\AccountModel;
use Doctrine\ORM\EntityManager;

/**
 * Class for authorize user.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class UserAuthorization
{
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $repeatPassword;
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var array
     */
    protected $errors = [];
    /**
     * @var array
     */
    protected $response = [];

    /**
     * UserAuthorization constructor.
     * @param string $username
     * @param string $password
     * @param string $repeatPassword
     * @param EntityManager $entityManager
     */
    public function __construct(string $username, string $password, string $repeatPassword, EntityManager $entityManager)
    {
        $this->username = $username;
        $this->password = $password;
        $this->repeatPassword = $repeatPassword;
        $this->entityManager = $entityManager;

        $this->authUsername();
        $this->authPassword();
    }

    private function authUsername()
    {
        /**
         * @var $model AccountModel
         */
        $model = $this->entityManager->getRepository('app\Model\User\AccountModel')->findBy(['username' => $this->username]);
        if (!$this->username)
            $this->errors['usernameEmpty'] = true;
        elseif (strlen($this->username) > 32 || strlen($this->username) < 5)
            $this->errors['usernameLength'] = true;
        elseif (!empty($model))
            $this->errors['usernameExists'] = true;
        else
            $this->response['username'] = $this->username;
    }

    private function authPassword()
    {
        if (!$this->password)
            $this->errors['passwordEmpty'] = true;
        elseif (strlen($this->password) > 32 || strlen($this->password) < 8)
            $this->errors['passwordLength'] = true;
        elseif ($this->password !== $this->repeatPassword)
            $this->errors['repeatPassword'] = true;
        else {
            $passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);
            $this->response['password'] = $passwordHashed;
        }
    }

    /**
     * @return array|null
     */
    public function getResults(): ?array
    {
        if ($this->errors)
            return null;

        return $this->response;
    }

    /**
     * @return array|null
     */
    public function getErrors(): ?array
    {
        if ($this->errors)
            return $this->errors;

        return null;
    }
}