<?php

namespace Forms;

use Forms\Inputs\CheckboxInput;
use Forms\Inputs\FileInput;
use Forms\Inputs\Hidden;
use Forms\Inputs\Select;
use Forms\Inputs\Submit;
use Forms\Inputs\Text;
use Forms\Inputs\TextareaInput;
use Forms\Inputs;


/**
 * Abstract Form Base Class
 */
abstract class FormBase
{
    /**
     * @var array
     */
    public $models = [];
    /**
     * @var array|null
     */
    public $config = [];
    /**
     * @var CheckboxInput[]|Hidden[]|Select[]|string[]|Submit[]|Text[]
     */
    public $fields = [];
    /**
     * @var array, $_GET, $_POST
     */
    protected $data;
    /**
     * @var bool
     */
    public $isValid = false;

    /**
     * @param $models
     * @param array $params
     */
    public function __construct($models, $params = null)
    {
        $this->models = $models;
        $this->config = $params;
    }

    /**
     * @return string
     */
    public function getStartTag()
    {
        $config = $this->config;
        $form = "<form";
        $form .= $config['id'] ? " id=\"{$config['id']}\"" : null;
        $form .= $config['name'] ? " name=\"{$config['name']}\"" : null;
        $form .= $config['action'] ? " action=\"{$config['action']}\"" :null;
        $form .= isset($config['enctype']) && $config['enctype'] ? " enctype=\"{$config['enctype']}\"" : null;
        $form .= $config['method'] ? " method=\"{$config['method']}\"" : null;
        $form .=">";
        return $form;
    }


    /**
     * This function checks the type
     * of the input and sets the field for themm
     *
     * @param $field
     * @return CheckboxInput|Hidden|Select|string|Submit|Text
     */
    public function generateField($field)
    {
        $newField = '';
        switch ($field['type']) {
            case 'textarea':
                require_once CLASSES . 'Forms/Inputs/TextareaInput.php';
                $newField = new TextareaInput();
                $field['rows'] ? $newField->setRows($field['rows']) : null;
                $field['cols'] ? $newField->setCols($field['cols']) : null;
                $field['value'] ? $newField->setValue($field['value']) : null;
                $field['form'] ? $newField->setForm($field['form']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
                if (isset($_POST['errorBody']) && $_POST['errorBody']){
                    $field['errorMessage'] ? $newField->setError($field['errorMessage']) : null;
                }
                break;
            case 'file':
                require_once CLASSES . 'Forms/Inputs/FileInput.php';
                $newField = new FileInput();
                $field['accept'] ? $newField->setAccept($field['accept']) : null;
                $field['value'] ? $newField->setValue($field['value']): null;
                $field['type'] ? $newField->setType($field['type']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                if (isset($_POST['errorFile']) && $_POST['errorFile']){
                    $field['errorMessage'] ? $newField->setError($field['errorMessage']) : null;
                }
                break;
            case 'text':
                require_once CLASSES . 'Forms/Inputs/TextInput.php';
                $newField = new Text();
                $field['type'] ? $newField->setType($field['type']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['value'] ? $newField->setValue($field['value']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
                if (isset($_POST['errorTitle']) && $_POST['errorTitle'] && isset($field['errorMessage'])){
                    $field['errorMessage'] ? $newField->setError($field['errorMessage']) : null;
                }
                break;
            case 'password':
                require_once CLASSES . 'Forms/Inputs/PasswordInput.php';
                $newField = new Inputs\Password();
                $field['type'] ? $newField->setType($field['type']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
                break;
            case 'submit':
                require_once CLASSES . 'Forms/Inputs/SubmitInput.php';
                $newField = new Inputs\Submit();
                break;
            case 'hidden':
                require_once CLASSES . 'Forms/Inputs/HiddenInput.php';
                $newField = new Inputs\Hidden();
                $field['value'] ? $newField->setValue($field['value']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
                break;
            case 'checkbox':
                require_once CLASSES . 'Forms/Inputs/CheckboxInput.php';
                $newField = new Inputs\CheckboxInput();
                $field['type'] ? $newField->setType($field['type']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['options'] ? $newField->setOptions($field['options']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
                break;
            case 'select':
                require_once CLASSES . 'Forms/Inputs/SelectInput.php';
                require_once CLASSES . 'Forms/Inputs/OptionInput.php';
                $newField = new Inputs\Select();
                $values = null;
                $field['multiple'] ? $newField->setMultiple($field['multiple']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['options'] ? $newField->setOptions($field['options']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
                break;
        }
        return $newField;
    }

    /**
     * @param $field
     * @return bool|Hidden|Select|string|Submit|Text|CheckboxInput
     */
    public function addField($field)
    {
        if ($newField = $this->generateField($field)) {
            $this->fields[$field['priority']] = $newField;
            return $newField;
        };
        return false;
    }
    
    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *Validate the form
     */
    public function validate()
    {
        $valid = true;

        foreach ( $this->fields as $field ) {
            if ( $this->isFieldPosted( $field ) ) {

                if ( ! $field->isValid() ) {
                    $valid = false;
                }
            }
        }

       return $valid;

    }

    /**
     * @param Hidden|Select|string|Submit|Text $field
     * @return bool
     */
    private function isFieldPosted( $field )
    {

        return array_key_exists( $field->getName(), $this->data ) && $field->getName() !== 'submit';
    }

    //

    //                foreach($field->getValidators() as $validator){
//                    if (!$validator->validate($value)) {
//                        $invalidCount++;
//                    }
//                }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     *
     * @param object $field
     * @return array
     */
    public function getField($field)
    {
        foreach($this->fields as $value){
            if($value->getName() === strtolower($field)){
                return $value;
            }
        }
        return false;
    }

    /**
     * @param $field
     * @param $value
     * @return $this
     */
    public function setField($field, $value){
        $test = $this->getField($field);
        $test->setValue($value);
        return $this;
    }

    /**
     * @return string
     */
    public function getEndTag()
    {
        return '</form>';
    }
}