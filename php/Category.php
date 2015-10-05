<?php
/**
 * Created by PhpStorm.
 * User: jgthibault
 * Date: 2015-04-28
 * Time: 05:38
 */

class Category {
    /*public $UserName;
    public $Password;
    public $FirstName;
    public $LastName;
    public $Created;*/

    public function getFullName()
    {
        return $this->Id . ' ' . $this->Description;
    }
} 