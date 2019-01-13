<?php

namespace Controller;

use Core\App;
use Model\EntriesModel;

/**
 * Entries controller, managing all processes of
 * entries system.
 *
 * Class EntriesController
 *
 * @category Controller
 *
 * @package Controller
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/mvc-engine
 */
class EntriesController extends App
{
    public function showEntries()
    {
        $em = $this->getEntityManager();

        $model = $em->getRepository('Model\EntriesModel')->findAll();

        $this->render('Entries/showEntries.html.twig', [
            'entries' => $model
        ]);
    }

    public function addEntry()
    {
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $em = $this->getEntityManager();
            $model = new EntriesModel();

            $model->setTitle($_POST['title']);
            $model->setContent($_POST['content']);

            $em->persist($model);
            $em->flush();

            $this->redirect('showEntries');
        } else {
            $this->render('Entries/addEntry.html.twig');
        }
    }

    public function removeEntry()
    {
        if ($_GET['id'] && $_GET['id'] !== 0) {
            $em = $this->getEntityManager();

            $model = $em->find('Model\EntriesModel', $_GET['id']);
            if ($model) {
                $em->remove($model);
                $em->flush();
            }
        }

        $this->redirect('showEntries');
    }
}