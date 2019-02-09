<?php

namespace uber\Utils\Auth\User;

/**
 * Handler for errors in UserAuthorization class.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class HandleUserAuthorizationErrors
{
    private $errors = [];

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        $this->handle();
    }

    private function handle()
    {
        if (isset($this->errors['usernameEmpty']))
            echo "Username cannot be empty.<br>";
        elseif (isset($this->errors['usernameLength']))
            echo "Username length must have from 5 to 32 characters.<br>";
        elseif (isset($this->errors['usernameExists']))
            echo "User with this username already exists.<br>";

        if (isset($this->errors['passwordEmpty']))
            echo "Password cannot be empty.<br>";
        elseif (isset($this->errors['passwordLength']))
            echo "Password length must have from 5 to 32 characters.<br>";
        elseif (isset($this->errors['repeatPassword']))
            echo "Passwords are not the same.<br>";
    }
}