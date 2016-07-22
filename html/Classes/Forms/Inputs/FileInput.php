<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 22.07.2016
 * Time: 13:50
 */

namespace Forms\Inputs;


class FileInput extends BaseInput
{

    public function __construct(){
        $this->type = 'file';
    }

    /**
     * @return string
     */
    public function getInput()
    {
        $required = $this->required ? ' required' : null;
        return "<input type='$this->type' name='$this->name'/>";
    }

}