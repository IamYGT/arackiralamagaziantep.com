<?php

/**
 * Created by PhpStorm.
 * User: Abdulkadir
 * Date: 20.11.2016
 * Time: 00:50
 */
class Form
{

  public static $Default = ['labelClass'=>'col-md-3','divClass'=>'col-md-9','div'=>false];

  public function __construct($param)
  {

  }

    public static function Open($data=array())
    {

    if(isset($data['token']) and $data['token'])
    {
        $token = md5(uniqid(rand(), TRUE));
        $_SESSION[((isset($data['id'])) ? $data['id'].'_':null).'token'] = $token;
        $_SESSION[((isset($data['id'])) ? $data['id'].'_':null).'token_time'] = time();
        setcookie(((isset($data['id'])) ? $data['id'].'_':null).'token', $token, time() + (86400 * 30), "/");
        setcookie(((isset($data['id'])) ? $data['id'].'_':null).'token_time', time(), time() + (86400 * 30), "/");
        $data['token_value'] =  $token;
    }
       echo self::inc('Form/formOpen',$data);
    }



    public static function Input($name='',$data=array())
    {

      $data['name'] = $name;
      echo self::inc('Form/input',$data);
    }
   public static function Hidden($name=null,$data=array())
    {
        $data['name'] = $name;
        $data['type'] = 'hidden';
        echo self::inc('Form/input',$data);
    }
   public static function Email($name=null,$data=array())
    {
        $data['name'] = $name;
        $data['type'] = 'email';
        echo self::inc('Form/input',$data);
    }
    public static function Text($name=null,$data=array())
    {
        $data['name'] = $name;
        $data['type'] = 'text';
        echo self::inc('Form/input',$data);
    }
    public static function Password($name=null,$data=array())
    {
        $data['name'] = $name;
        $data['type'] = 'password';
        echo self::inc('Form/input',$data);
    }
    public static function Submit($name=null,$data=array())
    {
        $data['value'] = $name;
        $data['type'] = 'submit';
        echo self::inc('Form/input',$data);
    }
    public static function Captcha($key=null)
    {
       if(!is_array($key))
           $data['key'] = $key;
       else
           $data = $key;
        echo self::inc('Form/captcha',$data);
    }

   public static function Select($name=null,$data=array()){ $data['name'] = $name; echo self::inc('Form/select',$data);}
   public static function Textarea($data=array()){ echo self::inc('Form/textarea',$data);}
   public static function Label($data=array()) {  echo self::inc('Form/label',$data);}
   public static function Helper($data=array()) {  echo self::inc('Form/helper',$data);}
   public static function Close($data=array()){  echo self::inc('Form/formClose',$data);}

    public  static  function inc($file,$data=array())
    {
        $data = array_merge(Form::$Default,$data);
        if($file and file_exists(__DIR__.'/'.$file.'.php')):
            ob_start();
            if($data) extract($data);
            include(__DIR__.'/'.$file.'.php');
            return ob_get_clean();
        else:
            return null;
        endif;
    }


}