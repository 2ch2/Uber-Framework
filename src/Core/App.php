<?php

namespace Core;

use Core\Providers\DoctrineServiceProvider;
use Core\Providers\TwigServiceProvider;
use Core\Router\UrlGenerator;
use Doctrine\ORM\EntityManager;

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
     * Variable, that includes Twig Environment
     * for correct View working.
     *
     * @var \Twig_Environment|null
     */
    private $view;

    /**
     * Variable, that includes Entity Manager
     * for correct Model working.
     *
     * @var EntityManager
     */
    private $entityManager;

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

        $doctrine = new DoctrineServiceProvider($this->providersConfig['database']);
        $this->entityManager = $doctrine->provide();
    }

    /**
     * @param string $name
     * @param array $data
     */
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

    /**
     * Redirecting to page from given parameters.
     *
     * @param string $name
     * @param array $data
     */
    public function redirect(string $name, array $data = []){
        header('Location: '. $this->urlGenerator->generate($name, $data));
        exit;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    private function loadProvidersConfig()
    {
        $this->providersConfig = require_once(__DIR__ . '/../Include/providers_config.inc.php');
    }
}