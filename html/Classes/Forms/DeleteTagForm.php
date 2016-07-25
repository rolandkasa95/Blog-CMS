<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 25.07.2016
 * Time: 16:03
 */

namespace Forms;


class DeleteTagForm extends FormCommon implements FormInterface
{
    public function __construct($models)
    {
        $params = [
            'name' => 'manageTags',
            'id' => 'form1',
            'method' => 'post',
            'action' => 'index.php?action=deleteTags',
        ];
        parent::__construct($models, $params);

        $button = $this->getField('Submit');
        $button->setValue('Delete');


        //Sort the fields by priority
        ksort($this->fields);
    }
}