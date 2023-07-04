<?php

namespace AdminPanel;


class Notlar extends Settings  {

    public $SayfaBaslik = 'Notlar';
    public  $modulName = 'Notlar';
    public $icbaslik ;
    private $js = array();
    private $css = array();
    private $siteURL;
    private $set;


    public function __construct($settings)
    {
        parent::__construct($settings);

        $this->siteURL = $this->GetSettings('url').$this->GetSettings('adminfolder');

        $this->set = $settings;
        $this->AuthCheck();
    }

    public function index($id=null)
    {
           return $this->liste($id);
    }




    public function ekle($id=null)
    {



        $this->icbaslik = 'Not Ekle';
        if(isset($id) and $id) $haber = $this->dbConn->tekSorgu('select * from notlar WHERE id='.$id);
        $text = '';
        $form = new Form($this->set);
        $text .= $form::formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        $text .= $form::input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Not Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));
        // $text .= $form::select(array('title'=>'Lisr'));
        $text .= $form::textEditor(array('value'=>((isset($haber['detay']) ? $this->temizle($haber['detay']) :'')),'title'=>'Not Detayı','name'=>'detay','id'=>'haberDetay','height' => '350'));
        $text .= $form::file(array('url'=>$this->BaseURL().'upload','title'=>'Not Resmi','name'=>'NotResim','resimBoyut'=>$this->settings['haberResimBoyut'],'src'=>((isset($haber['resim'])) ? $haber['resim'] :'')));
        //$text .= $form::input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Haber Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));
        $this->js[] = $form::editorJS($this->BaseURL());
        $text .= $form::submitButton();
        $text .= $form::formClose();



        return $text;


    }



    public function kaydet($id=null)
    {
       $images =  array('image'=>$_POST['NotResim'],'crop'=>$_POST['crop_NotResim']);
        $files =  json_encode($images,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $image  = array('resim'=>$files);

        if(isset($id) and $id):

            $this->dbConn->update('notlar',array_merge(array('baslik'=>$_POST['baslik'],'tarih'=>date('d/m/Y H:i:s'),'detay'=>$this->kirlet($_POST['detay'])),$image),$id);
        else:

            $this->dbConn->insert('notlar',array('baslik'=>$_POST['baslik'],'tarih'=>date('d/m/Y H:i:s'),'detay'=>$this->kirlet($_POST['detay']),'resim'=>$files));
        endif;
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function sil($id=null)
    {
        if($id) $this->dbConn->sil('DELETE FROM notlar where id='.$id);
        $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }


    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {
        $pagelist = new Pagelist();

        return $pagelist->Pagelist(array(
            'title'=> 'Not Listesi',
            'button' => array(array('title'=>'Not Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
            'p'=>array(
                array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                array('dataTitle'=>'baslik', 'class'=>'sort')
            ),
            'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
            'pdata' => $this->dbConn->sorgu('select * from notlar ORDER   BY  sira'),
            'baslik'=>array(
                array('title'=>'ID','width'=>'4%'),
                array('title'=>'Başlık','width'=>'80%')
            )

        ));


    }

    public function CustomPageCss($url)
    {
        // Sadece bu sayfa için gerekli Stil dosyaları eklenebilir
        $text = '';
        foreach($this->css as $css) $text .= $css;
        return $text;

    }


    public function CustomPageJs($url)
    {
        // Sadece bu sayfa için gerekli javascript dosyaları eklenebilir
        $text = '';
        foreach($this->js as $js) $text .= $js;
        return $text;
    }

}