<?php

namespace app\Utils\Auth;

use app\Model\User\AccountModel;
use Doctrine\ORM\EntityManager;
use uber\Utils\StringUtils;

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
     * @var array
     */
    protected $lang;

    /**
     * UserAuthorization constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->lang = $lang = StringUtils::loadJson('Lang/en_lang.json');
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $repeatPassword
     */
    public function authSignIn(string $username, string $email, string $password, string $repeatPassword)
    {
        /**
         * @var $model AccountModel
         */
        $model = $this->entityManager->getRepository('app\Model\User\AccountModel')->findBy(['username' => $username]);
        if (!$username)
            $this->errors['username'] = $this->lang['Errors']['SignUp']['Username']['Empty'];
        elseif (strlen($username) > 32 || strlen($username) < 5)
            $this->errors['username'] = $this->lang['Errors']['SignUp']['Username']['Length'];
        elseif (!empty($model))
            $this->errors['username'] = $this->lang['Errors']['SignUp']['Username']['Exists'];
        else
            $this->response['username'] = $username;

        $verifiedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        $model = $this->entityManager->getRepository('app\Model\User\AccountModel')->findBy(['email' => $verifiedEmail]);
        if (!$email)
            $this->errors['email'] = $this->lang['Errors']['SignUp']['Email']['Empty'];
        elseif(strlen($verifiedEmail) > 32 || strlen($verifiedEmail) < 5)
            $this->errors['email'] = $this->lang['Errors']['SignUp']['Email']['Length'];
        elseif (!filter_var($verifiedEmail, FILTER_VALIDATE_EMAIL) || $verifiedEmail != $email)
            $this->errors['email'] = $this->lang['Errors']['SignUp']['Email']['Valid'];
        elseif (!empty($model))
            $this->errors['email'] = $this->lang['Errors']['SignUp']['Email']['Exists'];
        else
            $this->response['email'] = $verifiedEmail;


        if (!$password)
            $this->errors['password'] = $this->lang['Errors']['SignUp']['Password']['Empty'];
        elseif (strlen($password) > 32 || strlen($password) < 8)
            $this->errors['password'] = $this->lang['Errors']['SignUp']['Password']['Length'];
        elseif ($password !== $repeatPassword)
            $this->errors['repeatPassword'] = $this->lang['Errors']['SignUp']['Password']['Repeat'];
        else {
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
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