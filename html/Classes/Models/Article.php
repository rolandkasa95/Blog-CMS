<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 26.07.2016
 * Time: 14:12
 */

namespace Models;


class Article extends Model
{
    private $title;
    private $id;
    private $body;
    private $urlImage;

    public function __construct($param)
    {
        if(is_integer($param)){
            $this->setId($param);
        }elseif (is_string($param)){
            $this->setTitle($param);
        }
    }

    /**
     * @return mixed
     */
    public function getUrlImage()
    {
        return $this->urlImage;
    }

    /**
     * @param mixed $urlImage
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getById()
    {
        try{

        }catch (\PDOException $e)
    }
}