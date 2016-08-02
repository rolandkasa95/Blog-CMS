<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 02.08.2016
 * Time: 15:14
 */

namespace Validators;


class ArticleValidate
{
    public static function valid(){
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
        return;
    }

}