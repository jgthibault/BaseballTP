<?php
/**
 * Created by PhpStorm.
 * User: jgthibault
 * Date: 2015-04-21
 * Time: 22:07
 */
/*
 * Test
 */
function checkLength($string, $len)
{
    if (strlen($string) > $len || strlen($string) <= 0)
    {
        return false;
    }

    return true;
}