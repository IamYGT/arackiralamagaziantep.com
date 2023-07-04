<?php

namespace AdminPanel;


class Index extends Settings {

    public $SayfaBaslik = 'Anasayfa';

    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
    }

   public function index()
   {
       $html ='';
       $widget = new Widget($this->settings);
       $slayt = $this->dbConn->teksorgu('select count(id) as sayi from slayt');
       $kategori = $this->dbConn->teksorgu('select count(id) as sayi from kategoriler');
       $sayfalar = $this->dbConn->teksorgu('select count(id) as sayi from yazilar');


       $html .= $widget->smalbox(array('data'=>array(
           array('title'=>'SLAYTLAR',
               'count'=> $slayt['sayi'],
               'icon'=>'fa fa-image',
               'color'=>'maroon',
               'link'=>array(
                   'title'=>'Slayt Listesi',
                   'href'=>$this->BaseAdminURL('Slayt/liste')
               )
           ),

           array('title'=>'SAYFALAR',
               'count'=> $sayfalar['sayi'],
               'icon'=>'fa fa-file-text',
               'color'=>'yellow',
               'link'=>array(
                   'title'=>'SAYFALAR',
                   'href'=>$this->BaseAdminURL('Sayfa/Sayfaliste')
               )
           ),

       )));





       return $html;
   }




}