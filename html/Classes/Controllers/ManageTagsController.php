<?php

namespace Controllers;


use Forms\manageTagsForm;
use Models\Model;
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
        $this->model = new \Models\Model();
        var_dump(isset($_POST['submit']) && $_POST['submit'] === 'Delete');
        if (isset($_POST['submit']) && $_POST['submit'] === 'Delete') {
            $this->model->deleteTag($_SESSION['delete']);
        }
        var_dump(isset($_POST['submit']) && $_POST['submit'] === 'Update' && isset($_POST['updateTo']) && !empty($_POST['updateTo']));
        if (isset($_POST['submit']) && $_POST['submit'] === 'Update' && isset($_POST['updateTo']) && !empty($_POST['updateTo'])) {
            $this->model->updateTag($_SESSION['delete']);
        }
        ob_end_clean();
    }
}