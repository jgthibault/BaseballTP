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
    const db = "macave";

    private $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli(self::host, self::user, self::pass, self::db);
    }

    function __destruct()
    {
        $this->mysqli->close();
    }

    function execute($query)
    {
        if ($result = $this->mysqli->query($query))
        {
            return $result;
        }

        return null;
    }

    function getCount($query)
    {
        $result = self::execute($query);

        if ($result != null)
        {
            return $result->num_rows;
        }

        return 0;
    }

    function exists($query)
    {
        return self::getCount($query) >= 1;
    }


} 