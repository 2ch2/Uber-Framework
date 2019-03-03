<?php

namespace app\Http\Controller;

use app\Model\EntriesModel;
use uber\Core\Router\UrlGenerator;
use uber\Utils\DataManagement\VariablesManager;
use uber\Utils\ExceptionUtils;

/**
 * Entries controller, managing all processes of
 * entries system.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class EntriesController extends \uber\Http\Controller
{
    /**
     * @var VariablesManager
     */
    private $variablesManager;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * EntriesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->variablesManager = new variablesManager();
        $this->urlGenerator = new UrlGenerator();
    }

    public function displayAction()
    {
        $em = $this->getEntityManager();

        /**
         * @var $model EntriesModel
         */
        $model = $em->getRepository('app\Model\EntriesModel')->findAll();

        $this->render('Entries/displayAction.html.twig', [
            'entries' => $model
        ]);
    }

    public function addAction()
    {
        if ($this->variablesManager->isPostExists('title') && $this->variablesManager->isPostExists('content')) {
            $em = $this->getEntityManager();
            $model = new EntriesModel();

            $model->setTitle($this->variablesManager->post('title'));
            $model->setContent($this->variablesManager->post('content'));

            try {
                $em->persist($model);
                $em->flush();
            } catch (\Exception $exception) {
                ExceptionUtils::displayExceptionMessage($exception);
            }

            $this->urlGenerator->redirect('displayEntries');
        } else {
            $this->render('Entries/addAction.html.twig');
        }
    }

    public function removeAction()
    {
        if ($this->variablesManager->isGetExists('id') && $this->variablesManager->get('id') !== 0) {
            $em = $this->getEntityManager();

            try {
                /**
                 * @var $model EntriesModel
                 */
                $model = $em->find('app\Model\EntriesModel', $this->variablesManager->get('id'));
            } catch (\Exception $exception) {
                ExceptionUtils::displayExceptionMessage($exception);
            }

            if (isset($model)) {
                try {
                    $em->remove($model);
                    $em->flush();
                } catch (\Exception $exception) {
                    ExceptionUtils::displayExceptionMessage($exception);
                }
            }
            $this->urlGenerator->redirect('displayEntries');
        }
    }
}