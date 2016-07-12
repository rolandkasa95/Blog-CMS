<?php

namespace Forms\Inputs;
/**
 * Class InputCheckbox
 */
class CheckboxInput extends BaseInput implements InputInterface
{
    /**
     * @var string
     */
    public $options = [];
    public $valueString;
    public $str;

    /**
     * Checkbox constructor.
     */
    public function __construct(){
        $this->type = 'checkbox';
        $this->value = true;
        $this->required = false;
    }

    public function getInput(){
        $j = 0;
        foreach ($this->options as $key => $option) {
            $this->str .= ' ' . "<input type=\"checkbox\" name=\"tags.$j\" value=\"$option\"> $option</input>";
            $j++;
        }
        return explode('</input>',$this->str);
    }

    /**
     * @param $options
     */
    public function setOptions($options){
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getValueString()
    {
        return $this->valueString;
    }

    /**
     * @param mixed $valueString
     * @return $this
     */
    public function setValueString($valueString)
    {
        $this->valueString = $valueString;
        return $this;
    }
}