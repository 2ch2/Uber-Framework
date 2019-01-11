<?php

namespace Core\Router;

/**
 * That's routing collection, management info about routes.
 *
 * Class RouteCollection
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
        $this->route[$name] = $item;
    }

    /**
     * @param  string $name
     * @return Route|null
     */
    public function get(string $name): ?Route
    {
        if (array_key_exists($name, $this->route)) {
            return $this->route[$name];
        }

        return null;
    }

    /**
     * @return array
     */
    public function getAll(): ?array
    {
        return $this->route;
    }
}