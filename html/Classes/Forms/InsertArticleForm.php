<?php

namespace Forms;

use Controllers\configController;
use Models\Model;
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
            'name' => 'insertArticle',
            'id' => 'form1',
            'method' => 'post',
            'action' => '#',
        ];
        parent::__construct($models, $params);

        //Add username
        $this->addField([
            'label' => 'Title: ',
            'type' => 'text',
            'name' => 'title',
            'priority' => 1,
            'required' => false,
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
            'error' => 'Please Enter a valid title',
        ]);

        $this->addField([
           'label' => 'Body: ',
            'type' => 'textarea',
            'rows' => 8,
            'cols' => 50,
            'form' => 'form1',
            'name' => 'body',
            'value' => '',
            'required' => false,
            'priority' => 2,
            'validator' =>[
              'StringLengthValidator' => [
               'minimum' => 15,
                  'maximum' => 50000000,
              ],
                'AlnumValidator',
                'requiredValidator',
            ],
            'error' => 'Please enter a valid body',
        ]);

        //Add country and data options
        $this->models = new Model();
        $title = $this->models->selectTags1();
        $this->addField([
            'label' => 'Please Select the Tags: ',
            'type' => 'checkbox',
            'name' => 'tags',
            'priority' => 7,
            'required' => true,
            'value' => '',
            'options' => $title,
            'validator' => [
                'InArrayValidator' => $title,
                'requiredValidator',
            ],
        ]);

        $this->addField([
            'label' => 'Tag Name: ',
            'type' => 'text',
            'name' => 'tag',
            'priority' => 8,
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
        $button->setValue('Publish');

        //Sort the fields by priority
        ksort($this->fields);
    }
}