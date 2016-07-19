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

class manageTagsForm
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

        $this->addField([
            'label' => 'Tag To Update: ',
            'type' => 'select',
            'name' => 'update',
            'multiple' => false,
            'priority' => 2,
            'required' => false,
            'value' => '',
            'validator' => [
              'InArrayValidator' => $result,
            ],
        ]);

        $this->addField([
           'label' => 'Update To: ',
            'type' => 'text',
            'name' => 'updateTo',
            'required' => false,
            'priority' => 3,
            'value' => '',
            'validator' =>[
                'AlphaValidator',
                'requiredValidator',
            ],
        ]);

        $this->addField([
            'label' => 'Tag Name to add: ',
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