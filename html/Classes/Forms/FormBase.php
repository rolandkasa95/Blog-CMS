<?php

namespace Forms;
use Forms\Inputs\Text;
use Forms\Inputs\TextareaInput;


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
     * @var array
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
        $form .= $config['method'] ? " method=\"{$config['method']}\"" : null;
        $form .=">";
        return $form;
    }

    /**
     * Generates fields from a configuration array
     * @return bool
     */
    public function generateFields()
    {
        $config = $this->config;
        $newField = null;
        foreach ($config['fields'] as $field) {
            $newField = $this->generateField($field);
        }

        if (!$newField) {
            return false;
        } else {
            //Set common fields
            !empty($field['value']) ? $newField->setValue($field['value']) : null;
            !empty($field['name']) ? $newField->setName($field['name']) : null;
            !empty($field['required']) ? $newField->setRequired($field['required']) : null;
            !empty($field['priority']) ? $this->fields[$field['priority']] = $newField : null;
        }

        ksort($this->fields);
        return true;
    }

    /**
     * This function checks the type
     * of the input and sets the field for themm
     *
     * @param $field
     * @return Checkbox|Hidden|Select|string|Submit|Text
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
                $field['form'] ? $newField->setForm($field['form']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
                break;
            case 'text':
                require_once CLASSES . 'Forms/Inputs/TextInput.php';
                $newField = new Text();
                $field['type'] ? $newField->setType($field['type']) : null;
                $field['label'] ? $newField->setLabel($field['label']) : null;
                $field['name'] ? $newField->setName($field['name']) : null;
                $field['validator'] ? $newField->setValidators($field['validator']) : null;
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
     * @return bool|Checkbox|Hidden|Select|string|Submit|Text
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
        $invalidCount = 0;
        foreach ($this->data as $key => $value) {
            foreach ($this->fields as $field) {
                if ($field->getName() == $key && $key !== 'submit') {
                    foreach($field->getValidators() as $validator){
                        if (!$validator->validate($value)) {
                            $invalidCount++;
                        }
                    }
                    if ( ! $invalidCount ) {
                        $field->setValid();
                        break;
                    }
                }
            }
        }
       if ($invalidCount){
           return false;
       }else{
           return true;
       }

    }

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