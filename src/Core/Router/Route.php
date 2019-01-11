<?php

namespace Core\Router;

/**
 * This is routing file, contains getters & setters
 * for correct route working.
 *
 * Class Route
 *
 * @category Routing
 *
 * @package Core\Router
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/mvc-engine
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
                $this->file = 'src/Controller/' . $config['file'];
                $this->class = 'Controller\\' . $config['class'];
                $this->method = $config['method'];
            } else {
                throw new \Exception('Config is not valid.');
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>
            File: ' . $e->getFile() . '<br>
            Line: ' . $e->getLine() . '<br>
            Trace: ' . $e->getTraceAsString();
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