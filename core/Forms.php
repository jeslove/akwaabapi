<?php 
namespace core\Forms;

use core\Csrf\Csrf;
use core\Validation\Validation;

abstract class Forms
{
    public static function sanitize($data)
    {
        // $data = htmlentities($data, ENT_QUOTES, 'UTF-8');

        // $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        return trim($data);
    }

    public static function get($input)
    {
        if(isset($_POST[$input]))
        {
            // Validate all POST[] input before sending to database.

            return Validation::purify(Csrf::anticsrf(self::sanitize($_POST[$input])));
        }
        else if(isset($_GET[$input]))
        {
            // Validate all GET[] input before sending to database.
            return Validation::purify(Csrf::anticsrf(self::sanitize($_GET[$input])));
        }
    }

    public static function set($input){

        if(isset($_POST[$input])){

            return  $_POST[$input];

        }
        else if(isset($_GET[$input]))
        {
            $fields = json_decode(file_get_contents("php://input"));

            return $_GET[$input];
        }
    }

    
    

    private static function getmethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public static function isPost()
    {
        // if($_SERVER['HTTP_ORIGIN'] == BASE_ORIGIN)
        // {
        //     return self::getmethod() === 'POST';
        // }
        // else{echo json_encode(['status'=>'error','response'=>'Invalid Requested url']);}

        return self::getmethod() === 'POST';
    }

    public static function isGet()
    {
        // if($_SERVER['HTTP_ORIGIN'] == BASE_ORIGIN)
        // {
        //     return self::getmethod() === 'GET';
        // }
        // else{echo json_encode(['status'=>'error','response'=>'Invalid Requested url']);}


        return self::getmethod() === 'GET';
    }


    public function paragraph($str, $len){

        if(empty($str))
        {
            return "";
        }
        else if(mb_strlen($str, 'UTF-8') > $len)
        {
            return mb_substr($str, 0, $len, "UTF-8") . " ...";
        }
        else
        {
            return mb_substr($str, 0, $len, "UTF-8");
        }
    }

}