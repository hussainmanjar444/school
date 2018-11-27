<?php
/**
 * Created by PhpStorm.
 * User: rnsdk
 * Date: 2/21/2018
 * Time: 7:08 PM
 */

namespace app\helpers;


class Encription
{

    /**
     * @param $pure_string
     * @return mixed
     */
    public static function encryptIt($pure_string)
    {
        return $pure_string;
        error_reporting(E_ALL ^ E_DEPRECATED);
       // 
        //$key = Configuration::get('encrypt_key'); //key to encrypt and decrypts.
        $key="jsfkhskdjfhksdhjk";
        $iv = 23;
        $dirty = array("+", "/", "=");
        $clean = array("_p_", "_s_", "_e_");
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $_SESSION['iv'] = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        $encrypted_string = base64_encode($encrypted_string);
        return urlencode(str_replace($dirty, $clean, $encrypted_string));
    }

    /**
     * @param $encrypted_string
     * @return string
     */
    public static function decryptIt($encrypted_string)
    {
        return $encrypted_string;
        error_reporting(E_ALL ^ E_DEPRECATED);
        //return $encrypted_string;
        //$key = Configuration::get('encrypt_key'); //key to encrypt and decrypts.
         $key="jsfkhskdjfhksdhjk";
        $iv = 23;
        $dirty = array("+", "/", "=");
        $clean = array("_p_", "_s_", "_e_");
        $string = base64_decode(str_replace($clean, $dirty, $encrypted_string));
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $string, MCRYPT_MODE_ECB, $iv);
        return urldecode($decrypted_string);
    }
}