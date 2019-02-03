<?php

namespace uber\Core\Router;

use uber\Utils\ExceptionUtils;

/**
 * This is routing file, contains getters & setters
 * for correct route working.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class Route
{
    /**
     * Url in web browser.
     *
     * @var string
     */
    protected $path;
    /**
     * File, which contains name of controller class.
     *
     * @var string
     */
    protected $file;
    /**
     * Controller class.
     *
     * @var string
     */
    protected $class;
    /**
     * Function in controller class.
     *
     * @var string
     */
    protected $method;
    /**
     * Default content for variables in url.
     *
     * @var array
     */
    protected $defaults;
    /**
     * Regex for variables in url.
     *
     * @var array
     */
    protected $params;

    /**
     * Route constructor.
     *
     * @param string $path
     * @param array $config
     * @param array $params
     * @param array $defaults
     */
    public function __construct(string $path, array $config, array $params = [], array $defaults = [])
    {
        $this->path = $path;

        try {
            if (isset($config['file']) && isset($config['class']) && isset($config['method'])) {
                $this->file = 'app/Http/Controller/' . $config['file'];
                $this->class = 'app\\Http\\Controller\\' . $config['class'];
                $this->method = $config['method'];
            } else {
                throw new \Exception('Routes config is not valid.');
            }
        } catch (\Exception $exception) {
            ExceptionUtils::displayFullExceptionDetails($exception);
            exit;
        }
        $this->setParams($params);
        $this->setDefaults($defaults);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @param string $controller
     */
    public function setFile(string $controller)
    {
        $this->file = $controller;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     * @return array
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }
}