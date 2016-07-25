<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 25.07.2016
 * Time: 15:39
 */

namespace Forms;


use Models\Model;

class EditTagForm extends FormCommon
{
    public function __construct($models){

        $this->models = new Model();
        $params = [
            'name' => 'manageTags',
            'id' => 'form1',
            'method' => 'post',
            'action' => 'index.php?action=deleteTags',
        ];
        parent::__construct($models, $params);


        $result = $this->models->selectTags1();
        //Add username
        $this->addField([
            'label' => 'Tag to Manage: ',
            'type' => 'select',
            'name' => 'delete',
            'multiple' => false,
            'priority' => 1,
            'value' => '',
            'options' => $result,
            'validator' => [
                'InArrayValidator' => $result,
                'requiredValidator',
            ],
        ]);

        //Adjust the button attributes
        $button = $this->getField('Submit');
        $button->setValue('Modify');

        //Sort the fields by priority
        ksort($this->fields);

    }
}