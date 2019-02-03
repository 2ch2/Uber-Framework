<?php

namespace uber\Core;

use uber\Core\Router\Router;
use uber\Utils\ExceptionUtils;

/**
 * Main framework class.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
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
                throw new \Exception('Page not found.');
            }
        } catch (\Exception $exception) {
            header("HTTP/1.1 404 Not Found");
            ExceptionUtils::displayExceptionMessage($exception);
            exit;
        }
    }
}