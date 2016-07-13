<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 11.07.2016
 * Time: 15:01
 */

namespace Forms\Inputs;


class TextareaInput extends BaseInput implements InputInterface
{
    public $rows;
    public $cols;
    public $form;
    /**
     * Text constructor.
     */
    public function __construct(){
        $this->type = 'textarea';
        $this->required = true;
    }

    public function setRows($rows){
        $this->rows=$rows;
    }

    public function setCols($cols){
        $this->cols=$cols;
    }

    public function setForm($form){
        $this->form=$form;
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return "<textarea name=\"$this->name\" rows=\"$this->rows\" cols=\"$this->cols\" form=\"$this->form\">$this->value</textarea>";
    }
}