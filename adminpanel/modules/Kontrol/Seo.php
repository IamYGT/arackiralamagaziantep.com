<?php
namespace AdminPanel;

use AdminPanel\Form;

class Seo extends Settings  {

    public $SayfaBaslik = '';
    public $modulName = 'Seo';
    public $icbaslik ;


    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

    public function index($id=null)
    {
      $this->liste($id);
    }




    public function ekle($id=null)
    {



    }



    public function kaydet($id=null)
    {

    }

    public function sil($id=null)
    {

    }
    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {

    }

    public function CustomPageCss($url)
    {
    }


    public function CustomPageJs($url)
    {

    }

}