<?php

namespace Views;

/**
 * Class View
 */
class View
{
    /**
     * @param $param
     */
    public function render($param){
        require LAYOUTS . 'html/' . $param;
    }
}