<?php

namespace AdminPanel;


class Widget extends  Settings
{
    public  $sidebar;
    public   $settings;

    public  function __construct($settings)
    {

        parent::__construct($settings);


        $this->settings = $settings;

    }


    public function bulten($data,$id)
    {
        return $this->_inc('Modal/bulten',array_merge(array('data'=>$data,'id'=>$id)));
    }


    public function modal($data,$id)
    {
        return $this->_inc('Modal/modal',array_merge(array('data'=>$data,'id'=>$id)));
    }

    public function fileLoad($data)
    {
        return $this->_inc('Modal/fileupload',$data);
    }


    public function teknik($id)
    {
        return $this->_inc('Modal/teknik',array('id'=>$id));
    }


    public function infoBox($data)
    {
        return $this->_inc('Modal/infobox',$data);
    }

    public function smalbox($data)
    {
        return $this->_inc('Modal/smalbox',$data);
    }


    public function report($data)
    {
        return $this->_inc('Modal/report',$data);
    }

    public function infoform($data)
    {
        return $this->_inc('Modal/infoform',$data);
    }

}
