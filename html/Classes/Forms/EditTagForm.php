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

        $params = [
            'name' => 'manageTags',
            'id' => 'form1',
            'method' => 'post',
            'action' => '#',
        ];
        parent::__construct($models, $params);


        $this->models = new Model();
        $result = $this->models->selectTags1();
        //Add username
        $this->addField([
            'label' => 'Tag to Delete',
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
        $button->setValue('Publish');

        //Sort the fields by priority
        ksort($this->fields);

    }
}