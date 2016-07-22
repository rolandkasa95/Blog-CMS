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
     * FormBase to the Insert output.
     * @param $models
     */
    public function __construct($models)
    {
        $params = [
            'name' => 'insertArticle',
            'id' => 'form1',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
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
            'error' => 1,
            'errorMessage' => 'Please Enter a valid Title'
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
            'error' => 1,
            'errorMessage' => 'Please Enter a valid Body',
        ]);

        $this->addField([
           'label' => 'Image:',
            'type' => 'file',
            'name' => 'fileToUpload',
            'value' => '',
            'required' => false,
            'priority' => 3,
        ]);

        //Add country and data options
        $this->models = new Model();

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