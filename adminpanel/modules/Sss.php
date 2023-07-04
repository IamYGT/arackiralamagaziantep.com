<?php

namespace AdminPanel;

use AdminPanel\Form;

class Sss extends Settings  {

    public $SayfaBaslik = 'Sıkça Sorulan Sorular';
    public  $modulName = 'Sss';
    public $icbaslik ;
    private $js = array();
    private $css = array();
    private $siteURL;
    private $set;
    private $module = 'sss';
    private $table = 'sss';
    private $tablelang = 'sss_lang';


    public function __construct($settings)
    {
      parent::__construct($settings);

        parent::__construct($settings);
        $this->AuthCheck();
    }
    public function index()
    {

    }
    public function ekle($id=null)
    {
        $this->icbaslik = 'Soru Ekle';
        if(isset($id) and $id) $haber = $this->dbConn->tekSorgu('select * from '.$this->table.' WHERE id='.$id);
        $text = '';
        $form = new Form($this->settings);
        $text .= $form->formOpen(array('method'=>'POST','action'=> $this->BaseAdminURL($this->modulName.'/kaydet'.((isset($id)) ? '/'.$id :'')),'fileUpload'=>true,'id'=>'form_sample_3','class'=>'','icbaslik'=>$this->icbaslik));
        $text .= $form->input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Soru','name'=>'baslik','id'=>'baslik','help'=>''));
        $text .= $form->textEditor(array('value'=>((isset($haber['detay']) ? $this->temizle($haber['detay']) :'')),'title'=>'Cevap','name'=>'detay','id'=>'detay','help'=>'','height'=>'320'));
           //$text .= $form->input(array('value'=>((isset($haber['gonderen']) ? $haber['gonderen'] :'')),'title'=>'Gönderen','name'=>'gonderen','id'=>'gonderen','help'=>''));
          //$text .= $form->input(array('value'=>((isset($haber['gorevi']) ? $haber['gorevi'] :'')),'title'=>'Mesleği','name'=>'gorevi','id'=>'gorevi','help'=>''));
         //$text .= $form->select(array('title'=>'Lisr'));
        //$text .= $form->textEditor(array('value'=>((isset($haber['detay']) ? $this->temizle($haber['detay']) :'')),'title'=>'Haber Detayı','name'=>'detay','id'=>'haberDetay','height' => '350'));
       //$text .= $form->file(array('url'=>$this->BaseURL().'upload','title'=>'Resim','name'=>'YorumResim','resimBoyut'=>$this->settings['haberResimBoyut'],'src'=>((isset($haber['resim'])) ? $haber['resim'] :'')));
      //$text .= $form->input(array('value'=>((isset($haber['baslik']) ? $haber['baslik'] :'')),'title'=>'Haber Başlığı','name'=>'baslik','id'=>'baslik','help'=>''));
     //$this->js[] = $form->editorJS($this->BaseURL());
        $text .= $form->submitButton();
        $text .= $form->formClose();
        return $text;
    }
    public function kaydet($id=null)
    {
        $post = array(
            'baslik'=> $this->_POST('baslik'),
            'detay'=>$this->kirlet($this->_POST('detay')),
           //'kategori'=>$this->kirlet($this->_POST('kategori')),
          //'url'=> strtolower($this->perma($this->_POST('baslik'))),
         //'resim' => $this->_RESIM('HaberResim')
        );
       if(isset($id) and $id):
            $this->dbConn->update($this->table,$post,$id);
        // kaydet
        else:
            $this->dbConn->insert($this->table,$post);
        endif;

       $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }

    public function sil($id=null)
    {
       if($id) $this->dbConn->sil('DELETE FROM '.$this->table.' where id='.$id);
       $this->RedirectURL($this->BaseAdminURL($this->modulName.'/liste.html'));
    }
    /**
     * @param null $id
     * @return string
     */
    public function liste($id=null)
    {
        $pagelist = new Pagelist($this->settings);
        return $pagelist->Pagelist(array(
         'title'=> 'Soru Listesi',
         'page'=>'sss',
         'button' => array(array('title'=>'Soru Ekle','href'=>$this->BaseAdminURL($this->modulName.'/ekle.html'),'color'=>'green')),
         'p'=>array(
                      array('class'=>'sort','tabindex'=>0,'dataTitle'=>'id'),
                      array('dataTitle'=>'baslik', 'class'=>'sort')
                  ),
         'tools' =>array(array('title'=>'Düzenle','icon'=>'fa fa-times','url'=> $this->BaseAdminURL($this->modulName.'/ekle/'),'color'=>'blue'),
                         array('title'=>'Sil','icon'=>'fa fa-edit','url'=> $this->BaseAdminURL($this->modulName.'/sil/'),'color'=>'red')),
         'pdata' => $this->dbConn->sorgu('select * from '.$this->table.' ORDER   BY  sira'),
         'baslik'=>array(
                            array('title'=>'ID','width'=>'4%'),
                            array('title'=>'Soru','width'=>'80%')
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