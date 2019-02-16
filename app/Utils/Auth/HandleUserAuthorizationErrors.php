<?php

namespace app\Utils\Auth;

use uber\Utils\ExceptionUtils;
use uber\Utils\StringUtils;

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

    public function __construct(?array $errors)
    {
        if (is_array($errors)) {
            $this->errors = $errors;
            $this->handle();
        }
    }

    private function handle()
    {
        $lang = StringUtils::loadJson('Lang/en_lang.json');

        try {
            if (isset($this->errors['passwordEmpty']))
                throw new \Exception($lang['Errors']['SignUp']['passwordEmpty']."<br>");
            elseif (isset($this->errors['passwordLength']))
                throw new \Exception($lang['Errors']['SignUp']['passwordLength']."<br>");
            elseif (isset($this->errors['repeatPassword']))
                throw new \Exception($lang['Errors']['SignUp']['repeatPassword']."<br>");
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
        }

        try {
            if (isset($this->errors['usernameEmpty']))
                throw new \Exception($lang['Errors']['SignUp']['usernameEmpty']."<br>");
            elseif (isset($this->errors['usernameLength']))
                throw new \Exception($lang['Errors']['SignUp']['usernameLength']."<br>");
            elseif (isset($this->errors['usernameExists']))
                throw new \Exception($lang['Errors']['SignUp']['usernameExists']."<br>");
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
        }
    }
}