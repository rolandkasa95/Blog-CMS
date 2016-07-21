<?php

namespace Views;

/**
 * Class View
 */
class View
{

    protected $model;

    /**
     * @param $param
     */
    public function render($param,$model){
        $this->model = $model;
        if('loginpage.php' !== $param){
            require LAYOUTS . 'html/headerHtml.php';
        }
        require LAYOUTS . 'html/headHtml.html';
        require LAYOUTS . 'html/' . $param;
    }
}