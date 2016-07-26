<?php

namespace Controllers;


use Forms\manageTagsForm;
use Models\Model;
use Models\Tag;
use Views\View;

class ManageTagsController extends AppController
{
    public function init()
    {
        $view = new View();
        $this->model = new manageTagsForm(new Model());
        $view->render('manageTagsPage.php', $this->model);
        $this->manage();
    }

    /**
     * The form
     *
     * Validation and generation
     */

    public function manage()
    {
        ob_start();
        header_remove();
        $this->model = new Tag();
        if (isset($_POST['submit']) && $_POST['submit'] === 'Delete') {
            $this->model->deleteById($_SESSION['delete']);
        }
        if (isset($_POST['submit']) && $_POST['submit'] === 'Update' && isset($_POST['updateTo']) && !empty($_POST['updateTo'])) {
            $this->model->update($_SESSION['delete']);
        }
        ob_end_clean();
    }
}