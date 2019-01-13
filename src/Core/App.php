<?php

namespace Core;

use Core\Providers\TwigServiceProvider;
use Core\Router\UrlGenerator;

/**
 * Main file, managing classes entered
 * into the controller, backend process, etc...
 *
 * Class App
 *
 * @category Core
 *
 * @package Core
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/mvc-engine
 */
class App
{
    /**
     * Config, that includes
     * Service Provider settings.
     *
     * @var array
     */
    private $providersConfig;

    /**
     * @var \Twig_Environment|null
     */
    private $view;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->loadProvidersConfig();

        $this->urlGenerator = new UrlGenerator();

        $twig = new TwigServiceProvider($this->providersConfig['twig']);
        $this->view = $twig->provide([
            //Parameters, that you want to give for TwigServiceProvider
            'urlGenerator' => $this->urlGenerator
        ]);
    }

    public function render(string $name, array $data = [])
    {
        try {
            $body = $this->view->render('View/' . $name, $data);
            echo $body;
        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>
            File: ' . $e->getFile() . '<br>
            Line: ' . $e->getLine() . '<br>
            Trace: ' . $e->getTraceAsString();
            exit;
        }
    }

    private function loadProvidersConfig()
    {
        $this->providersConfig = require_once(__DIR__ . '/../Include/providers_config.inc.php');
    }
}