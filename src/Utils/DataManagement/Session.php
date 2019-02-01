<?php

namespace uber\Utils\DataManagement;

use uber\Utils\ExceptionUtils;

/**
 * Class, that includes methods for session
 * management.
 *
 * Class Session
 *
 * @category Utilities
 *
 * @package uber\Utils
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/kamil-ubermade/Uber-Framework
 */
class Session
{
    public function start()
    {
        if (!isset($_SESSION))
            session_start();
    }

    /**
     * @return bool
     */
    public function isStarted()
    {
        if (isset($_SESSION))
            return true;

        return false;
    }

    /**
     * @param string $name
     * @param $content
     */
    public function set(string $name, $content)
    {
        $_SESSION[$name] = $content;
    }

    /**
     * @param string $name
     * @param $content
     */
    public function setIfNotExists(string $name, $content)
    {
        if (!isset($_SESSION[$name]))
            $_SESSION[$name] = $content;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        try {
            if (isset($_SESSION[$name]))
                return $_SESSION[$name];

            throw new \Exception('Session with name "' . $name . '" does not exists.');
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
            exit;
        }
    }

    /**
     * @param string $name
     */
    public function unset(string $name)
    {
        try {
            if (isset($_SESSION[$name]))
                unset($_SESSION[$name]);
            else
                throw new \Exception('Session with name "' . $name . '" does not exists.');
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
            exit;
        }
    }

    public function destroy()
    {
        if (isset($_SESSION))
            session_destroy();
    }
}