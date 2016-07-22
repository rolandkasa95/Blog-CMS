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

    public $accept;

    public function __construct(){
        $this->type = 'file';
    }

    public function setAccept($accept){
        $this->accept = $accept;
    }
    /**
     * @return string
     */
    public function getInput(){
        $return = "<input type='$this->type' name='$this->name' accept='$this->accept'>";
        if(isset($this->error)){
            $return .= "<p style='color: red'>$this->error</p>";
        }
        return $return;
    }

}