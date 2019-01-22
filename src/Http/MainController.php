<?php

namespace uber\Http;

use uber\Providers\DoctrineServiceProvider;
use uber\Providers\TwigServiceProvider;
use uber\Core\Router\UrlGenerator;
use Doctrine\ORM\EntityManager;

/**
 * Main controller class.
 *
 * Class MainController
 *
 * @category Core
 *
 * @package uber\Http
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/Uber-Framework
 */
class MainController
{
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
        $this->urlGenerator = new UrlGenerator();

        $twig = new TwigServiceProvider(TWIG);
        $this->view = $twig->provide([
            //Parameters, that you want to give for TwigServiceProvider
            'urlGenerator' => $this->urlGenerator
        ]);

        $doctrine = new DoctrineServiceProvider(DATABASE);
        $this->entityManager = $doctrine->provide();
    }

    /**
     * @param string $name
     * @param array $data
     */
    public function render(string $name, array $data = [])
    {
        try {
            $body = $this->view->render($name, $data);
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
    public function redirect(string $name, array $data = [])
    {
        header('Location: ' . $this->urlGenerator->generate($name, $data));
        exit;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}