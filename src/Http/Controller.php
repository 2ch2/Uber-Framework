<?php

namespace uber\Http;

use app\Utils\Auth\AuthManager;
use app\Providers\DoctrineServiceProvider;
use app\Providers\TwigServiceProvider;
use uber\Core\Router\UrlGenerator;
use Doctrine\ORM\EntityManager;
use uber\Utils\DataManagement\SessionManager;
use uber\Utils\ExceptionUtils;

/**
 * Main controller class.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class Controller
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
     * class for correct Model working.
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Variable for Session Manager.
     *
     * @var SessionManager
     */
    public $sessionManager;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * Is true, when class is
     * called by ajax.
     *
     * @var bool
     */
    public $isAjax = false;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->isAjax();
        $this->urlGenerator = new UrlGenerator();
        $this->sessionManager = new SessionManager();

        $twig = new TwigServiceProvider(TWIG);
        $this->view = $twig->provide([
            //Parameters, that you want to give for TwigServiceProvider
            'urlGenerator' => $this->urlGenerator,
            'session' => $this->sessionManager
        ]);

        $doctrine = new DoctrineServiceProvider(DATABASE);
        $this->entityManager = $doctrine->provide();

        new AuthManager($this->entityManager);
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
        } catch (\Exception $exception) {
            ExceptionUtils::displayFullExceptionDetails($exception);
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

    /**
     * Checks, did controller is called by AJAX.
     */
    private function isAjax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
           $this->isAjax = true;
    }
}