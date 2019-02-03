<?php

namespace uber\Core\Router;

use uber\Utils\StringUtils;

/**
 * That's main class of routing system, taking part in
 * true URL reading.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class Router
{
    /**
     * A string that contains the
     * content of URL
     *
     * @var string
     */
    protected $url;

    /**
     * Collection, which contains all routes.
     *
     * @var RouteCollection
     */
    protected static $collection;

    /**
     * Name of controller file.
     *
     * @var string
     */
    protected $file;

    /**
     * Name of controller class.
     *
     * @var string
     */
    protected $class;

    /**
     * Name of function in assigned class.
     *
     * @var string
     */
    protected $method;

    /**
     * Router constructor.
     *
     * @param string $url
     * @param object $collection
     */
    public function __construct(string $url, ?object $collection = null)
    {
        if ($collection != null) {
            self::$collection = $collection;
        }

        $url = explode('?', $url);
        $this->url = $url[0];
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param RouteCollection $collection
     */
    public function setCollection(RouteCollection $collection)
    {
        self::$collection = $collection;
    }

    /**
     * @return \stdClass
     */
    public function getCollection()
    {
        return self::$collection;
    }

    /**
     * @param string $controller
     */
    public function setFile(string $controller)
    {
        $this->file = $controller;
    }

    /**
     * @return string|null
     */
    public function getFile(): ?string
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
     * @return string|null
     */
    public function getClass(): ?string
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
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param Route $route
     * @return bool
     */
    protected function matchRoute(Route $route): bool
    {
        $params = [];
        $key_params = array_keys($route->getParams());
        $value_params = $route->getParams();

        foreach ($key_params as $key) {
            $params['{' . $key . '}'] = $value_params[$key];
        }

        $url = $route->getPath();
        $url = str_replace(array_keys($params), $params, $url);
        $url = preg_replace('/<\w+>/', '.*', $url);
        preg_match("#^$url$#", $this->url, $results);

        if ($results) {
            $this->url = str_replace([(StringUtils::strlcs($url, $this->url))], [''], $this->url);
            $this->file = $route->getFile();
            $this->class = $route->getClass();
            $this->method = $route->getMethod();
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function run(): bool
    {
        foreach (self::$collection->getAll() as $route) {
            if ($this->matchRoute($route)) {
                $this->setGetData($route);
                return true;
            }
        }

        return false;
    }

    /**
     * Checks, did url is correct.
     *
     * @param Route $route
     */
    protected function setGetData(Route $route)
    {
        $route_path = $route->getPath();
        $trim = explode('{', $route_path);
        $parsed_url = str_replace([HTTP_SERVER], [''], $this->url);
        $parsed_url = preg_replace("#$trim[0]#", '', $parsed_url, 1);

        foreach ($route->getParams() as $key => $param) {
            if ($parsed_url[0] == '/') {
                $parsed_url = substr($parsed_url, 1);
            }

            preg_match("#$param#", $parsed_url, $results);
            if (!empty($results[0])) {
                $_GET[$key] = $results[0];
                $temp_url = explode($results[0], $parsed_url, 2);
                $parsed_url = $temp_url[1];
            }
        }

        foreach ($route->getDefaults() as $key => $default) {
            if (!isset($_GET[$key])) {
                $_GET[$key] = $default;
            }
        }
    }
}