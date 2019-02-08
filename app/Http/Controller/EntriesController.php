<?php

namespace app\Http\Controller;

use app\Model\EntriesModel;
use uber\Utils\DataManagement\VariablesManagement;
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
     * @var VariablesManagement
     */
    private $variables;

    /**
     * EntriesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->variables = new VariablesManagement();
    }

    public function displayAction()
    {
        $em = $this->getEntityManager();

        $model = $em->getRepository('app\Model\EntriesModel')->findAll();

        $this->render('Entries/displayAction.html.twig', [
            'entries' => $model
        ]);
    }

    public function addAction()
    {
        if ($this->variables->isPostExists('title') && $this->variables->isPostExists('content')) {
            $em = $this->getEntityManager();
            $model = new EntriesModel();

            $model->setTitle($this->variables->post('title'));
            $model->setContent($this->variables->post('content'));

            try {
                $em->persist($model);
                $em->flush();
            } catch (\Exception $exception) {
                ExceptionUtils::displayExceptionMessage($exception);
            }

            $this->redirect('displayEntries');
        } else {
            $this->render('Entries/addAction.html.twig');
        }
    }

    public function removeAction()
    {
        if ($this->variables->isGetExists('id') && $this->variables->get('id') !== 0) {
            $em = $this->getEntityManager();

            try {
                $model = $em->find('app\Model\EntriesModel', $this->variables->get('id'));
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
            $this->redirect('displayEntries');
        }
    }
}