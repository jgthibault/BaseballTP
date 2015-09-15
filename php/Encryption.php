<?php
/**
 * Created by PhpStorm.
 * User: jgthibault
 * Date: 2015-04-24
 * Time: 22:55
 */

class Encryption
{
    const Key = "password key";

    static function Encrypt($string)
    {
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(self::Key), $string, MCRYPT_MODE_CBC, md5(md5(self::Key))));
    }

    static  function Decrypt($string)
    {
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(self::Key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5(self::Key))), "\0");
    }
} 