<?php
/**
 * Created by PhpStorm.
 * User: VEMEDYA
 * Date: 03.03.2016
 * Time: 14:12
 */

namespace AdminPanel;


class Pagelist extends  Settings {


      public function __construct($settings=null)
      {
          parent::__construct($settings);

      }
     public function Pagelist($param=array())
    {
        return $this->_inc('Pagelist',array('param'=>$param));
    }

    public function Fotolist($param=array())
    {
        return $this->_inc('Fotolist',array('param'=>$param));
    }
}