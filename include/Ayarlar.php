<?php

namespace AdminPanel;

class Ayarlar
{

    public  $file;

    public function __construct($file=null)
    {

    }

 /*
    public function database($d=null)
    {
        $data =  $this->inc((($this->file) ? $this->file:'include/').'ayarlar/database');
        return ((isset($data[$d])) ? $data[$d]:((is_null($d)) ? $data:null));
    }

    public function file($d=null)
    {
        $data = $this->inc((($this->file) ? $this->file:'include/').'ayarlar/file');
        return ((isset($data[$d])) ? $data[$d]:((is_null($d)) ? $data:null));
    }

    public function lang($d=null)
    {
        $data = $this->inc((($this->file) ? $this->file:'include/').'ayarlar/lang');
        return ((isset($data[$d])) ? $data[$d]:((is_null($d)) ? $data:null));
    }

    public function config($d=null)
    {
        $data = $this->inc((($this->file) ? $this->file:'include/').'ayarlar/config');
        return ((isset($data[$d])) ? $data[$d]:((is_null($d)) ? $data:null));
    }


    public function security($d=null)
    {
        $data = $this->inc((($this->file) ? $this->file:'include/').'ayarlar/security');
        return ((isset($data[$d])) ? $data[$d]:((is_null($d)) ? $data:null));
    }


    public function boyut($d=null)
    {
        $data = $this->inc((($this->file) ? $this->file:'include/').'ayarlar/boyut');
        return ((isset($data[$d])) ? $data[$d]:((is_null($d)) ? $data:null));
    }

    public function sidebar($d=null)
    {
        $data = $this->inc((($this->file) ? $this->file:'include/').'ayarlar/sidebar');
        return ((isset($data[$d])) ? $data[$d]:((is_null($d)) ? $data:null));
    }
 */

    public function __call( $meth, $args ) {
        $data = $this->inc('ayarlar/'.$meth);
        return ((is_array($args) and count($args)>0) ? $data[$args[0]]:$data);
    }

    public function inc($file)
    {
        if($file and file_exists(__DIR__.'/'.$file.'.php')):
           return  include __DIR__.'/'.$file.'.php' ;
        else:
           return null;
        endif;
    }


}
