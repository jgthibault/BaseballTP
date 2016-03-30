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

    const C_SESSION_USER = "session_user";
	const C_SESSION_PASS = "session_pass";

    function __construct($username, $password, $mysql)
    {
        $this->MySql = $mysql;
		
		$result = $mysql->execute("SELECT * FROM user WHERE UserName = '" . $username . "' and Password = '" . $password . "'");
		
		if ($result->num_rows >= 1)
		{
			$this->User = $result->fetch_object("User");
			
			$_SESSION[self::C_SESSION_USER] = $username;
			$_SESSION[self::C_SESSION_PASS] = $password;
		}	
		else
		{
			$this->closeSession();
		}
    }

    function closeSession()
    {
        // remove all session variables
        session_unset();
    }

    static function isConnected()
    {
        if(isset($_SESSION[self::C_SESSION_USER]) && !empty($_SESSION[self::C_SESSION_USER]))
        {
            return true;
        }

        return false;
    }
} 