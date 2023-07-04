<?php


namespace AdminPanel;


class Home  extends Settings{

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

        $haber = $this->dbConn->teksorgu('select count(id) as sayi from haberler');
        $urunler = $this->dbConn->teksorgu('select count(id) as sayi from urunler');


        $html .= $widget->smalbox(array('data'=>array(
            array('title'=>'HABERLER',
                  'count'=> $haber['sayi'],
                  'icon'=>'fa  fa-newspaper-o',
                  'color'=>'aqua',
                  'link'=>array(
                           'title'=>'Haber Listesi',
                           'href'=>$this->BaseAdminURL('Haberler/liste')
                               )
                 ),
             array('title'=>'ÜRÜNLER',
                   'count'=>$urunler['sayi'],
                   'icon'=>'fa fa-product-hunt',
                   'color'=>'red',
                   'link'=>array(
                        'title'=>'Ürün Listesi',
                        'href'=>$this->BaseAdminURL('Urunler/liste')
                   )
                 ),
            array('title'=>'ONLİNE ZİYARETÇİ',
                  'count'=>'14',
                  'icon'=>'ion ion-ios-people-outline',
                  'color'=>'green',
                  'link'=>array(
                      'title'=>'Sitede Şuan Bulunan Ziyaretçi Sayısı',
                      'href'=>'',
                      'icon'=>''
                  )
            ),
        )));


        return $html;

    }

} 