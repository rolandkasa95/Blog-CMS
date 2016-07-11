<?php

namespace Forms;

use Controllers\configController;
use Models\selectTagsModel;
use Validators\AlnumValidator;

/**
 * Register Form Class
 */
class InsertArticleForm
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
            'label' => 'Title',
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
           'label' => 'Body',
            'type' => 'textarea',
            'rows' => 8,
            'cols' => 50,
            'form' => 'form1',
            'name' => 'body',
            'required' => true,
            'priority' => 2,
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
            'label' => 'Please Select the Tags',
            'type' => 'select',
            'name' => 'tags',
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
        $button->setValue('Publish');

        //Sort the fields by priority
        ksort($this->fields);
    }
}