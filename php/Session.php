<?php
/**
 * Created by PhpStorm.
 * User: jgthibault
 * Date: 2015-04-26
 * Time: 14:32
 */
class Session
{
    public $User;
    public $MySql;

    const C_SESSION = "session_obj";

    function __construct($username, $mysql)
    {
        $this->MySql = $mysql;

        $result = $mysql->execute("SELECT * FROM user WHERE UserName = '" . $username . "'");
        $User = $result->fetch_object("User");

        $_SESSION[self::C_SESSION] = self;
    }

    function closeSession()
    {
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
    }

    static function isConnected()
    {
        if(isset($_SESSION[self::C_SESSION]) && !empty($_SESSION[self::C_SESSION]))
        {
            return true;
        }

        return false;
    }
} 