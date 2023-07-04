<?php


namespace AdminPanel;


class refFoto extends Settings {

    public $SayfaBaslik = 'Referanslar - Resim';
    public  $modulName = 'refFoto';
    private $siteURL;
    public $icbaslik;
    private  $set;
    private $css;
    private $js;
    public $settings;

    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->AuthCheck();
        $this->settings = $settings;
    }

    public function index($id=null)
    {
        return $this->fotoekle($id);
    }





    public function referansResimduzenle($id=null)
    {
        $this->icbaslik = 'Galeri Ekle';
        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from dosyalar  WHERE id='.$id);
        $text = '';

        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/referansResimkaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>''));
        //   $text .= $form->textarea(array('value'=>((isset($yazi['detay']) ? $yazi['detay'] :'')),'title'=>'Açıklama','name'=>'ozet','id'=>'ozet','help'=>'','height'=>'120'));
        $text .= $form->file(array('url'=>$this->BaseURL('upload/referans'),'folder'=>'urunler','title'=>'Resim','name'=>'fotoResim','resimBoyut'=>$this->settings->boyut('icerik'),'src'=>((isset($urun['dosya'])) ? $urun['dosya'] :'')));
        $text .= $form->file(array('url'=>$this->BaseURL('upload/'),'title'=>'Resim Arka','name'=>'fotoResimArka','resimBoyut'=>$this->settings->boyut('icerik'),'src'=>((isset($urun['arka'])) ? $urun['arka'] :'')));
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;

    }


    public function aktif($id=null)
    {

        $durum = $this->_GET('durum');
        //$durum = (($durum==1) ? 0 :1);
        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        if($this->dbConn->update('dosyalar',array('arka'=>$durum),$id)) echo 1;else echo 0;

        exit;
    }




    public function referansResimEkle($id=0)
    {

        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from referanslar  WHERE id='.$id);

        $this->icbaslik = 'Referans Resim Ekle - '.$urun['firma'];

        $modul =  ((isset($_GET['modul'])) ? $_GET['modul']:1);


        $pagelist = new Pagelist($this->settings);

        return $pagelist->Fotolist(array(
            'title'=> 'Resim Listesi',
            'icbaslik' => $this->icbaslik,
            'id'=>$id,
            'page'=>'dosyalar',
            //    'button' => array(array('title'=>'Fotograf Ekle','href'=> $this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(
                array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/referansResimduzenle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/referansResimSil/'),'color'=>'red')),
            'yukle'=> array('type'=>'button','title'=>'Resim Ekle','class'=>'btn btn-danger','modul'=>$modul,'folder'=>'../'.$this->settings->config('folder').'referans/','name'=>((isset($urun['url'])) ? $urun['url']:null)),

            'buton'=> array(
                //   array('type'=>'radio','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/aktif/'),'item'=>array('aktif'=> 'Arka','pasif'=> 'Ön')),
            ),
            'pdata' => $this->dbConn->sorgu("select * from dosyalar where type=$modul and kid='$id' ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'60%'),
                //      array('title'=>'Arka','width'=>'5%'),
                //   array('title'=>'Aktif','width'=>'5%'),
                //   array('title'=>'Resimler','width'=>'8%'),

            )

        ));

    }






    public  function referansResimkaydet($id=null)
    {


        $post = array(
            'baslik'=> $this->_POST('baslik'),
            //'detay'=>$this->kirlet($this->_POST('detay')),
            // 'ustu'=> $this->_POST('kid'),
          //   'url_tr'=> strtolower($this->permalink($this->_POST('baslik'))),
            'dosya' => $this->_RESIM('fotoResim'),
            'arka' => $this->_RESIM('fotoResimArka')
        );

        // Güncelle
        if(isset($id) and $id):
            $this->dbConn->update('dosyalar',$post,$id);

        endif;
        $urun = $this->dbConn->teksorgu("select * from dosyalar where id='$id'");
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/referansResimEkle/'.$urun['kid'].'&modul='.$urun['type']));


    }



    public function referansResimSil($id=null)
    {
        $rec2 = $this->dbConn->tekSorgu("SELECT * FROM dosyalar WHERE id='$id'");

        $resim2= $this->resimGet($rec2["dosya"]);
        $kid = $rec2['kid'];
        $this->ResimSil($resim2,"../".$this->settings->config('url').'referans/'); // Eski resmi sil
        if($id) $this->dbConn->sil('DELETE FROM dosyalar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/urunResimEkle/'.$kid.'&modul='.$rec2['type']));
    }
} 