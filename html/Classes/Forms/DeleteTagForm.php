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
            'action' => '#',
        ];
        parent::__construct($models, $params);

        $button = $this->getField('Submit');
        $button->setValue('Update');


        //Sort the fields by priority
        ksort($this->fields);
    }
}