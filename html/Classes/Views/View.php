<?php

class View
{
    public function render($param){
        require '../../Layouts/' . $param;
    }
}