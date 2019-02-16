<?php

namespace uber\Utils\DataManagement;

use uber\Utils\ExceptionUtils;

/**
 * Class, that includes methods for session
 * management.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class Session
{
    /**
     * @var array
     */
    protected $session;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        if (isset($this->session)) {
            $this->session = $_SESSION;
        }
    }

    /**
     * Starts session and assigns true session
     * into local session variable.
     */
    public function start()
    {
        if (!isset($_SESSION)) {
            session_start();
            $this->session = $_SESSION;
        }
    }

    /**
     * @return bool
     */
    public function isStarted(): ?bool
    {
        if (isset($this->session))
            return true;

        return false;
    }

    /**
     * @param string $name
     * @param $content
     */
    public function set(string $name, $content)
    {
        $this->session[$name] = $content;
    }

    /**
     * @param string $name
     * @param $content
     */
    public function setIfNotExists(string $name, $content)
    {
        if (!isset($_SESSION[$name]))
            $this->session[$name] = $content;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isSessionExists(string $name): ?bool
    {
        if (isset($this->session[$name]))
            return true;
        else
            return false;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        try {
            if (isset($this->session[$name]))
                return $this->session[$name];

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
            if (isset($this->session[$name]))
                unset($this->session[$name]);
            else
                throw new \Exception('Session with name ' . $name . ' does not exists.');
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
            exit;
        }
    }

    public function destroy()
    {
        if (isset($this->session))
            session_destroy();
    }

    /**
     * Assigns the local session variable
     * into the true session.
     */
    public function assign()
    {
        $_SESSION = $this->session;
    }
}