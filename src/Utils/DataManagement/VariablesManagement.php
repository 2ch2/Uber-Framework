<?php

namespace uber\Utils\DataManagement;

use http\Env\Response;
use uber\Utils\ExceptionUtils;

/**
 * Simple class for managing with variables
 * like $_POST, &_GET.
 *
 * Class VariablesManagement
 *
 * @category Utilities
 *
 * @package uber\Utils\DataManagement
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/kamil-ubermade/Uber-Framework
 */
class VariablesManagement
{
    /**
     * @var array
     */
    protected $post;

    /**
     * @var array
     */
    protected $get;

    /**
     * VariablesManagement constructor.
     */
    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function post(string $name)
    {
        try {
            if (isset($this->post[$name]))
                return $this->post[$name];

            throw new \Exception('Post with name "' . $name . '" does not exists.');
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
            exit;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function isPostExists(string $name): ?bool
    {
        if (isset($this->post[$name]))
            return true;

        return false;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get(string $name)
    {
        try {
            if (isset($this->get[$name]))
                return $this->get[$name];

            throw new \Exception('Get with name "' . $name . '" does not exists.');
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
            exit;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function isGetExists(string $name): ?bool
    {
        if (isset($this->get[$name]))
            return true;

        return false;
    }
}