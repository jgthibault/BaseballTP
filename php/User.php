<?php
/**
 * Created by PhpStorm.
 * User: jgthibault
 * Date: 2015-04-28
 * Time: 05:38
 */

class User {
    public $UserName;
    public $Password;
    public $FirstName;
    public $LastName;
    public $Created;

    public function getFullName()
    {
        return $this->FirstName . ' ' . $this->LastName;
    }
} 