<?php

class Request
{

    public static function GETURL($a,$value=null)
    {
        $parts = parse_url($_SERVER['REQUEST_URI']);
        if(isset($parts) and $parts):
            if(isset($parts['query'])) parse_str($parts['query'], $query);
        endif;
        return (isset($query[$a]) and $query[$a]) ? Request::koru($query[$a]):$value;
    }

    public static function POST($post,$value=null)
    {
        return (isset($_POST[$post])) ?  Request::koru($_POST[$post]):$value;
    }


    public static function GET($get,$value=null)
    {
        return (isset($_GET[$get])) ? Request::koru($_GET[$get]):$value;
    }


    public static function getAll($get=null)
   {
    $a = [];
    if(isset($_GET) and is_array($_GET))
    foreach ($_GET as $name=>$value):
        $a[$name] = $value;
    endforeach;
       return $a;
   }

    public static function postAll($post=null)
    {
        $a = [];
        if(isset($_POST) and is_array($_POST))
            foreach ($_POST as $name=>$value):
                $a[$name] = $value;
            endforeach;
        return $a;
    }


    public  static function koru($value)
    {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        return $value;
    }

}
