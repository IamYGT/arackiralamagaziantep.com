<?php

/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 9.11.2016
 * Time: 17:02
 */
class Lang
{

    public  $lang;

    public function __construct($lang=null)
    {
        $this->lang = $lang;
    }


    public function __call( $meth, $args ) {

        if($meth and file_exists('include/lang/'.$this->lang.'/'.$meth.'.php')):
         if(isset($args[1]) and  file_exists('include/lang/'.$args[1].'/'.$meth.'.php'))
                $data = $this->inc('include/lang/'.$args[1].'/'.$meth);
             else
                $data = $this->inc('include/lang/'.$this->lang.'/'.$meth);
           else:
            $data = $this->inc('include/lang/tr/'.$meth);
          endif;
        return ((is_array($args) and count($args)>0) ? $data[$args[0]]:$data);
    }

    public function inc($file)
    {

        if($file.'.php' and file_exists($file.'.php')):
            return  include $file.'.php' ;
        else:
            return null;
        endif;
    }

}