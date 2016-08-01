<?php

namespace Models;


class Articles extends Model
{

    public $articleArray = [];


    /**
     * @return array
     */
    public function getArticleArray()
    {
        return $this->articleArray;
    }

}