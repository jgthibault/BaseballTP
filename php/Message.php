<?php
/**
 * Created by PhpStorm.
 * User: jgthibault
 * Date: 2015-04-21
 * Time: 22:30
 */

class Message
{
    const NoError = 0;
    const Length = 1;
    const Unicity = 2;
    const NotMatching = 3;
    const InvalidUserName = 4;
    const InvalidPassword = 5;

    static function getMessage($code)
    {
        switch($code)
        {
            case self::NoError:
                return "";
            case self::InvalidUserName:
                return "Le nom d'utilisateur est inexistant";
            case self::InvalidPassword:
                return "Le mot de passe est invalide";
            default:
                return "";
        }
    }

    /**
     * @param $code
     * @param $param1
     * @return int|string
     */
    static function getMessage1($code, $param1)
    {
        switch($code)
        {
            case self::Unicity:
                return sprintf("Le %s existe déjà", $param1);
            default:
                return "";
        }
    }

    /**
     * @param $code : Error code
     * @param $param1 : First argument
     * @param $param2 : Second argument
     * @return string : Error message
     */
    static function getMessage2($code, $param1, $param2)
    {
        switch($code)
        {
            case self::Length:
                return sprintf("Doit avoir entre %u et %u charactères", $param1, $param2);
            case self::NotMatching:
                return sprintf("Le champ '%s' et '%s' doivent être idendique", $param1, $param2);
            default:
                return "";
        }
    }
} 