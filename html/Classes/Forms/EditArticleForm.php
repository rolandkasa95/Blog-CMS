<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 13.07.2016
 * Time: 16:01
 */

namespace Forms;


use Models\editarticleModel;
use Models\Model;
use Models\selectTagsModel;

class EditArticleForm
    extends FormCommon implements FormInterface
{
    /**
     * RegisterForm constructor.
     *
     * This constructor sets the fields taken from
     * FormBase to the EditArticle output.
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

        $this->models = new Model();
        $result = $this->models->showArticle();
        //Add username
        $this->addField([
            'label' => 'Title: ',
            'type' => 'text',
            'name' => 'title',
            'priority' => 1,
            'required' => false,
            'value' => $result['title'],
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
            'value' => $result['body'],
            'form' => 'form1',
            'name' => 'body',
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

        //Add country and data options
        $this->models = new Model();

        $this->addField([
            'label' => 'Tag Name: ',
            'type' => 'text',
            'name' => 'tag',
            'priority' => 8,
            'required' => true,
            'value' => implode(',',$this->models->selectArticleTagNames()),
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