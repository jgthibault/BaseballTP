<?php
/**
 * Created by PhpStorm.
 * User: jgthibault
 * Date: 2015-04-22
 * Time: 20:43
 */

class MySql
{
    const host = "localhost:3306";
    const user = "root";
    const pass = "";
    const db = "baseball";

    private $mysqli;
	
    /////////////////////////////////////////////
    ///Description: Constructor of the class 
    ///				to connect mysql
    ///
    ///Parameters:
    ///
    ///return :
    /////////////////////////////////////////////
    function __construct()
    {
        $this->mysqli = new mysqli(self::host, self::user, self::pass, self::db);
		$this->mysqli->query('SET NAMES utf8');
    }
	
    /////////////////////////////////////////////
    ///Description: Disconnect database
    ///
    ///Parameters:
    ///
    ///return :
    /////////////////////////////////////////////
    function __destruct()
    {
        $this->mysqli->close();
    }
	
    /////////////////////////////////////////////
    ///Description: Execute a query
    ///
    ///Parameters:
    ///    $query : Query to execute
    ///
    ///return : The result
    /////////////////////////////////////////////
    function execute($query)
    {
        if ($result = $this->mysqli->query($query))
        { 
            return $result;
        }

        return null;
    }
	
	
	function prepare($query, $params) 
	{
		if ($stmt = $this->mysqli->prepare($query))
		{
		    call_user_func_array(array($stmt, "bind_param"), $this->refValues($params));    	
			$stmt->execute();
			$stmt->close(); 
		}
        
	}
    
    function refValues($arr)
    { 
        $refs = array();
 
        foreach ($arr as $key => $value)
        {
            $refs[$key] = &$arr[$key]; 
        }
 
        return $refs; 
    }
    
    /////////////////////////////////////////////
    ///Description: Get the number of records of
    /// a query
    ///
    ///Parameters:
    ///    $query : Query to execute
    ///
    ///return : Number of records
    /////////////////////////////////////////////
    function getCount($query)
    {
        $result = self::execute($query);

        if ($result != null)
        {
            return $result->num_rows;
        }

        return 0;
    }

    /////////////////////////////////////////////
    ///Description: Check if a query return atleast 
    /// one record
    ///
    ///Parameters:
    ///    $query : Query to execute
    ///
    ///return : True if query return 1 or more record
    /// false otherwise
    /////////////////////////////////////////////
    function exists($query)
    {
        return self::getCount($query) >= 1;
    }


} 