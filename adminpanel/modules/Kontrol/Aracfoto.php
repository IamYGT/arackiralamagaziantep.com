<?php


namespace AdminPanel;


class Aracfoto extends Settings {

    public $SayfaBaslik = '2. El Araç - Resim';
    public  $modulName = 'Aracfoto';
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





    public function Resimduzenle($id=null)
    {
        $this->icbaslik = '2.El Resim Ekle';
        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from dosyalar  WHERE id='.$id);
        $text = '';

        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','icbaslik'=>$this->icbaslik,'action'=>  $this->BaseAdminURL($this->modulName.'/Resimkaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>''));
        $text .= $form->input(array('value'=>((isset($urun['baslik']) ? $urun['baslik'] :'')),'title'=>' Başlık','name'=>'baslik','id'=>'baslik','help'=>''));
        //   $text .= $form->textarea(array('value'=>((isset($yazi['detay']) ? $yazi['detay'] :'')),'title'=>'Açıklama','name'=>'ozet','id'=>'ozet','help'=>'','height'=>'120'));
        $text .= $form->file(array('url'=>$this->BaseURL('upload/araclar'),'folder'=>'araclar','title'=>'Resim','name'=>'fotoResim','resimBoyut'=>$this->settings->boyut('icerik'),'src'=>((isset($urun['dosya'])) ? $urun['dosya'] :'')));
        $this->js[] = $form->editorJS($this->BaseURL());
        $text .= $form->submitButton(array('submit'=>($id) ? 'Güncelle':'Kaydet'));
        $text .= $form->formClose();
        return $text;

    }


    public function durum($id=null)
    {

        $durum = ((isset($_GET['durum'])) ? $_GET['durum'] : null);
        //$durum = (($durum==1) ? 0 :1);
        $id = ((isset($_GET['id'])) ? $_GET['id'] : null);
        if($this->dbConn->update('fotogaleri',array('durum'=>$durum),$id)) echo 1;else echo 0;

        exit;
    }







    public function ResimEkle($id=0)
    {

        if(isset($id) and $id) $urun = $this->dbConn->tekSorgu('select * from ikielaraclar  WHERE id='.$id);

        $this->icbaslik = '2. El  Resim Ekle - '.$urun['marka'].' '.$urun['versiyon'];


        $pagelist = new Fotolist($this->settings);

        return $pagelist->Fotolist(array(
            'title'=> '2 Araç Resim Listesi',
            'icbaslik' => $this->icbaslik,
            'id'=>$id,
            'page'=>'dosyalar',
            //    'button' => array(array('title'=>'Fotograf Ekle','href'=> $this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(
                array('title'=>'Düzenle','icon'=>'fa fa-times','url'=>$this->BaseAdminURL($this->modulName.'/Resimduzenle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=>$this->BaseAdminURL($this->modulName.'/aracResimSil/'),'color'=>'red')),
            'yukle'=> array('type'=>'button','title'=>'Resim Ekle','class'=>'btn btn-danger','modul'=>10,'folder'=>'../'.$this->settings->config('folder').'araclar/','name'=>((isset($urun['url'])) ? $urun['url']:null)),

            'buton'=> array(
                //array('type'=>'radio','dataname'=>'durum','url'=>$this->BaseAdminURL($this->modulName.'/durum/')),
            ),
            'pdata' => $this->dbConn->sorgu("select * from dosyalar where type=10 and kid='$id' ORDER   BY  sira"),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%'),
                //   array('title'=>'Aktif','width'=>'5%'),
                //   array('title'=>'Resimler','width'=>'8%'),

            )

        ));

    }








    public  function Resimkaydet($id=null)
    {


        $post = array(
            'baslik'=> $this->_POST('baslik'),
            //'detay'=>$this->kirlet($this->_POST('detay')),
            // 'ustu'=> $this->_POST('kid'),
            //'url'=> strtolower($this->perma($this->_POST('baslik'))),
            'dosya' => $this->_RESIM('fotoResim'));

        // Güncelle
        if(isset($id) and $id):
            $this->dbConn->update('dosyalar',$post,$id);

        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/urunResimEkle.html'));


    }



    public function aracResimSil($id=null)
    {
        $rec2 = $this->dbConn->tekSorgu("SELECT * FROM dosyalar WHERE id='$id'");

        $resim2= $this->resimGet($rec2["dosya"]);
        $kid = $rec2['kid'];
        $this->ResimSil($resim2,"../".$this->settings->config('url').'araclar/'); // Eski resmi sil
        if($id) $this->dbConn->sil('DELETE FROM dosyalar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/ResimEkle/'.$kid));
    }
} 