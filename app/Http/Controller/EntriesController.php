<?php

namespace app\Http\Controller;

use app\Model\EntriesModel;

/**
 * Entries controller, managing all processes of
 * entries system.
 *
 * Class EntriesController
 *
 * @category Controller
 *
 * @package app\Http\Controller
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/mvc-engine
 */
class EntriesController extends \uber\Http\MainController
{
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
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $em = $this->getEntityManager();
            $model = new EntriesModel();

            $model->setTitle($_POST['title']);
            $model->setContent($_POST['content']);

            $em->persist($model);
            $em->flush();

            $this->redirect('displayEntries');
        } else {
            $this->render('Entries/addAction.html.twig');
        }
    }

    public function removeAction()
    {
        if ($_GET['id'] && $_GET['id'] !== 0) {
            $em = $this->getEntityManager();

            $model = $em->find('app\Model\EntriesModel', $_GET['id']);
            if ($model) {
                $em->remove($model);
                $em->flush();
            }
        }

        $this->redirect('displayEntries');
    }
}