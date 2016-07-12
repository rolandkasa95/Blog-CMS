<?php

namespace Forms;

use Controllers\configController;
use Models\selectTagsModel;
use Validators\AlnumValidator;

/**
 * Register Form Class
 */
class insertTagForm
    extends FormCommon implements FormInterface
{
    /**
     * RegisterForm constructor.
     *
     * This constructor sets the fields taken from
     * FormBase to the RegisterForm output.
     * @param $models
     */
    public function __construct($models)
    {
        $params = [
            'name' => 'register',
            'id' => 'form1',
            'method' => 'post',
            'action' => '#',
        ];
        parent::__construct($models, $params);

        //Add username
        $this->addField([
            'label' => 'Tag Name: ',
            'type' => 'text',
            'name' => 'tag',
            'priority' => 1,
            'required' => true,
            'value' => '',
            'validator' => [
                'StringLengthValidator' => [
                    'minimum' => 2,
                    'maximum' => 100,
                ],
                'AlphaValidator',
                'DuplicationValidator',
                'requiredValidator',
            ],
        ]);

        //Adjust the button attributes
        $button = $this->getField('Submit');
        $button->setValue('Add Tag');

        //Sort the fields by priority
        ksort($this->fields);
    }
}