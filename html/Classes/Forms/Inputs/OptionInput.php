<?php

namespace Forms\Inputs;
/**
 * Class Input Option
 */
class Option
{
    /**
     * @var string
     */
    protected $label;
    /**
     * @var bool
     */
    protected $disabled = false;
    /**
     * @var bool
     */
    protected $selected = false;
    /**
     * @var string
     */
    protected $value;
    /**
     * @var string
     */
    protected $optionString;

    /**
     * @return string
     */
    public function getOption()
    {
        $option = "<option ";
        $option .= $this->value ? " value=\"$this->value\"" : null;
        $option .= $this->disabled ? " disabled" : null;
        $option .= $this->label ? " label=\"$this->label\"" : null;
        $option .= $this->selected ? " selected" : null;
        $option .= ">";
        $option .= $this->optionString;
        $option .= "</option>";
        return $option;
    }

    /**
     * @param $options
     * @return bool
     */
    public function getOptions($options)
    {
        $results = null;
        foreach ($options as $option) {
            $value = ucwords($option);
            $this->value = $value;
            $this->optionString = $value;
            $results[] = $this->getOption($option);
        }
        return $results ?: false;
    }

    /**
     * @param $param
     * @return $this
     */
    public function setOptionString($param)
    {
        $this->optionString = $param;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionString()
    {
        return $this->optionString;
    }

    /**
     * @param $param
     * @return $this
     */
    public function setLabel($param)
    {
        $this->label = ucfirst($param);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param boolean $disabled
     * @return $this
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return boolean
     */
    public function isSelected()
    {
        return $this->selected;
    }

    /**
     * @param boolean $selected
     * @return $this
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
