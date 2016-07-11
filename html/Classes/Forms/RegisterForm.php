<?php

namespace Forms;

use Controllers\configController;
use Models\selectTagsModel;
use Validators\AlnumValidator;

/**
 * Register Form Class
 */
class RegisterForm extends FormCommon implements FormInterface
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
            'action' => 'index.php',
        ];
        parent::__construct($models, $params);

        //Add username
        $this->addField([
            'label' => 'title',
            'type' => 'text',
            'name' => 'title',
            'priority' => 1,
            'required' => true,
            'value' => '',
            'validator' => [
                'StringLengthValidator' => [
                    'minimum' => 5,
                    'maximum' => 100,
                ],
                'AlnumValidator',
                'DuplicationValidator',
                'requiredValidator',
            ],
        ]);

        $this->addField([
           'label' => 'textarea',
            'type' => 'textarea',
            'rows' => 8,
            'cols' => 80,
            'form' => 'form1',
            'name' => 'body',
            'required' => true,
            'validator' =>[
              'StringLengthValidator' => [
               'minimum' => 15,
                  'maximum' => 50000000,
              ],
                'AlnumValidator',
                'requiredValidator',
            ],
        ]);

        //Add country and data options
        $this->models = new selectTagsModel();
        $countries = $this->models->selectTags1();
        $this->addField([
            'label' => 'Country',
            'type' => 'select',
            'name' => 'country',
            'multiple' => false,
            'priority' => 7,
            'required' => true,
            'value' => '',
            'options' => $countries,
            'validator' => [
                'InArrayValidator' => $countries,
                'requiredValidator',
            ],
        ]);

        //Adjust the button attributes
        $button = $this->getField('Submit');
        $button->setValue('register');

        //Sort the fields by priority
        ksort($this->fields);
    }
}