<?php

namespace uber\Core;

use uber\Core\Router\Router;

/**
 * Main framework class
 *
 * Class Framework
 *
 * @category Core
 *
 * @package uber\Core
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/Uber-Framework
 */
class Framework
{
    /**
     * @var Router;
     */
    private $router;

    /**
     * Framework constructor.
     */
    public function __construct()
    {
        $this->router = new Router(SERVER_PROTOCOL . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    }

    /**
     * Exception handler for routing.
     */
    public function handle()
    {
        $this->router->run();

        try {
            $file = $this->router->getFile();
            $class = $this->router->getClass();
            $method = $this->router->getMethod();

            if (file_exists($file)) {
                require_once $file . '';
                $obj = new $class();
                $obj->$method();
            } else {
                throw new \Exception('Not found');
            }
        } catch (\Exception $e) {
            header("HTTP/1.1 404 Not Found");
            echo $e->getMessage();
        }
    }
}