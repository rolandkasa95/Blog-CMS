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

        $button = $this->getField('Submit');
        $button->setValue('Delete');

        //Sort the fields by priority
        ksort($this->fields);
    }
}