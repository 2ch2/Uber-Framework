<?php

namespace uber\Core\Router;

/**
 * That's routing collection, management info about routes.
 *
 * Class RouteCollection
 *
 * @category Routing
 *
 * @package uber\Core\Router
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/kamil-ubermade/Uber-Framework
 */
class RouteCollection
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @param string $name
     * @param Route $item
     */
    public function add(string $name, Route $item)
    {
        $this->routes[$name] = $item;
    }

    /**
     * @param  string $name
     * @return Route|null
     */
    public function get(string $name): ?Route
    {
        if (array_key_exists($name, $this->routes)) {
            return $this->routes[$name];
        }

        return null;
    }

    /**
     * @return array
     */
    public function getAll(): ?array
    {
        return $this->routes;
    }
}