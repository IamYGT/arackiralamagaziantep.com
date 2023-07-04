<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 02.03.2016
 * Time: 18:44
 */

namespace AdminPanel;




class Form  extends Settings{

    public $settings;
    public $baseURL;

    public function __construct($settings)
    {
        parent::__construct($settings);
      $this->settings = $settings;

      $this->baseURL = $this->BaseURL();
    }
	
	 public function hidden($param=array())
   {
       return self::_inc('Form/input',$param);
   }

    public function selectmulti($a=array())
    {
       return self::_inc('Form/selectmulti',$a);
    }

    public function harita($param = array())
    {
        return self::_inc('Form/harita',$param);
    }

    public function input($param=array())
   {
       return self::_inc('Form/input',$param);
   }

    public function date($param=array())
    {

          $param['type'] = 'date';
        return self::_inc('Form/input',$param);
    }
    public function link($param=array())
    {
        $param['type'] = 'link';
        return self::_inc('Form/input',$param);
    }

    public function fiyatekle($param=array())
    {
        return self::_inc('Form/fiyatekle',$param);
    }

    public function textarea($param=array())
    {
        return self::_inc('Form/textarea',$param);
    }


    public  function checkbox($param=array())
    {
        $param['type'] = 'checkbox';
        return self::_inc('Form/checkbox',$param);
    }


    public  function select($param=array())
    {
       return self::_inc('Form/select',$param);
    }

    public function  textEditor($param=array())
    {
        return self::_inc('Form/textEditor',$param);
    }

    public  function file($param=array())
    {
        return self::_inc('Form/file',$param);
    }

    public  function file2($param=array())
    {
        //return self::_inc('Form/file2_',$param);
    }

    public   function submitButton($param=array())
   {
       return self::_inc('Form/submit',$param);
   }

    public function imageUpload($param=array())
    {
      //  return self::_inc('Form/imageUpload',$param);
    }

    public function formOpen($param=array())
    {
        return self::_inc('Form/FormOpen',$param);
    }

    public function formClose($param=array())
    {
        return self::_inc('Form/FormClose',$param);
    }

    //$sql,$id,$ek,$kat,
    /**
     * @param array $param    required sql -> "select * form sayfakategori " ,kat ->  ust id  , option (value,title)
     * @param $ek
     * @param $id
     */
    public  function parent($param=array(), $ek, $id)
    {

        // echo $param['selected'];

        $text ='';

        if(isset($param['sql'])):
            $selected = (isset($param['selected'])) ? json_decode($param['selected'],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES):0;
        //$param['sql']." where $kat = '$id'";
        $kid = ((isset($param['kat']) and $param['kat']) ?  $kid= $param['kat']."='$id'":null);
        $data =  $this->dbConn->sorgu($param['sql'].$kid);
        if(is_array($data))
            foreach($data as $dt):
                $text .= '<option value="'.$dt[$param['option']['value']].'" '.((is_array($selected)) ?((in_array($dt[$param['option']['value']],$selected)) ? 'selected="selected"':null):(($dt[$param['option']['value']]==$selected) ? 'selected="selected"':null ) ).'>'.str_repeat('- ',$ek).$dt[$param['option']['title']].'</option>';
                if(isset($param['kat']) and $param['kat'])    $text .=  $this->parent($param,$ek+1,$dt['id']);
            endforeach;
         endif;
        if(isset($param['array']) and is_array($param['array'])):

            foreach ($param['array'] as $item):
                $text .= '<option value="'.$item[$param['option']['value']].'" '.((isset($param['selected'])) ?(($item[$param['option']['value']] == $param['selected']) ? 'selected="selected"':null):null).'>'.$item[$param['option']['title']].'</option>';
            endforeach;


        endif;


        return $text;
    }
/*
    public function _inc($file,$data=null)
    {

        $data = array_merge($data);
        if($data) extract($data);
        if($file and file_exists('theme/'.$this->settings->config('adminTheme').'/layout/Form/'.$file.'.php')):
            ob_start();
            include 'theme/'.$this->settings->config('adminTheme').'/layout/Form/'.$file.'.php';
            return ob_get_clean();
        else:
            if($file and file_exists('theme/admin/layout/Form/'.$file.'.php')):
                ob_start();
                include 'theme/admin/layout/Form/'.$file.'.php';
                return ob_get_clean();
            else:
                return null;
            endif;
        endif;

    }

*/
} 