<?php

namespace uber\Core\Router;

use uber\Utils\ExceptionUtils;

/**
 * Here is some comment
 *
 * Class UrlGenerator
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
class UrlGenerator
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var RouteCollection
     */
    protected $collection;

    /**
     * @var Route
     */
    protected $route;

    /**
     * UrlGenerator constructor.
     */
    public function __construct()
    {
        $this->router = new Router(SERVER_PROTOCOL . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
        $this->collection = $this->router->getCollection();
    }

    /**
     * @param  string $name
     * @param  array|null $data
     * @return string|null
     */
    public function generate(string $name, array $data = null): ?string
    {
        $this->route = $this->collection->get($name);

        try {
            if (isset($this->route)) {
                $path = $this->route->getPath();
                $defaults = $this->route->getDefaults();
                return $this->matchUrl($data, $path, $defaults);
            } else {
                throw new \Exception('Routing "' . $name . '" does not exist.');
            }
        } catch (\Exception $exception) {
            ExceptionUtils::displayExceptionMessage($exception);
            exit;
        }
    }

    /**
     * @param  array|null $data
     * @param  string $path
     * @param  array|null $defaults
     * @return string|null
     */
    private function matchUrl(?array $data, string $path, ?array $defaults): ?string
    {
        if (is_array($data)) {
            $key_data = array_keys($data);
            foreach ($key_data as $key) {
                $data2['{' . $key . '}'] = $data[$key];
            }

            return str_replace(array_keys($data2), $data2, $path);
        } elseif (!empty($defaults)) {
            $key_defaults = array_keys($defaults);
            foreach ($key_defaults as $key) {
                $defaults2['{' . $key . '}'] = $defaults[$key];
            }
            return str_replace(array_keys($defaults2), $defaults2, $path);
        }
        return $path;
    }
}
